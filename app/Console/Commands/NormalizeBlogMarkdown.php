<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * One-off content migration for posts authored before the body was rendered
 * as Markdown.
 *
 * Legacy posts use "1. Section Title" on its own line as a pseudo-heading,
 * with the paragraph running directly underneath. Markdown reads that as an
 * ordered-list item and swallows the title into the body paragraph, so the
 * section headings disappear from the document outline. This promotes them to
 * real `## ` headings, which is what gives each post a crawlable H2 structure.
 *
 * Idempotent: a post that already contains a Markdown heading is skipped.
 */
class NormalizeBlogMarkdown extends Command
{
    protected $signature = 'blog:normalize-markdown {--dry-run : Show the changes without writing}';

    protected $description = 'Promote legacy "1. Title" pseudo-headings in blog posts to Markdown H2 headings';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $backup = [];
        $changed = 0;

        foreach (BlogPost::all() as $post) {
            if (str_contains($post->content, '## ')) {
                $this->line("  <fg=gray>skip</> #{$post->id} — already has Markdown headings");

                continue;
            }

            $converted = $this->convert($post->content);

            if ($converted === $post->content) {
                $this->line("  <fg=gray>skip</> #{$post->id} — nothing to convert");

                continue;
            }

            $backup[] = ['id' => $post->id, 'content' => $post->content];
            $headings = substr_count($converted, "\n## ") + (str_starts_with($converted, '## ') ? 1 : 0);
            $this->line("  <fg=green>convert</> #{$post->id} — {$headings} heading(s) — {$post->title}");

            if (! $dryRun) {
                $post->content = $converted;
                $post->saveQuietly();
            }

            $changed++;
        }

        if ($dryRun) {
            $this->newLine();
            $this->comment('Dry run — nothing written.');

            return self::SUCCESS;
        }

        if ($backup) {
            $path = 'backups/blog-content-before-markdown.json';
            Storage::disk('local')->put($path, json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->newLine();
            $this->info("Original content backed up to storage/app/private/{$path}");
        }

        $this->info("{$changed} post(s) updated.");

        return self::SUCCESS;
    }

    /**
     * Promote "N. Title" lines that are immediately followed by body text.
     * A numbered line followed by a blank line is a genuine list item and is
     * left alone.
     */
    private function convert(string $content): string
    {
        $lines = preg_split('/\r\n|\r|\n/', $content);
        $out = [];

        foreach ($lines as $i => $line) {
            $next = $lines[$i + 1] ?? '';

            $isPseudoHeading = preg_match('/^\s*\d+\.\s+(\S.{1,78})$/u', $line, $m)
                && ! str_ends_with(rtrim($m[1]), '.')
                && trim($next) !== '';

            if ($isPseudoHeading) {
                $out[] = '## '.trim($m[1]);
                $out[] = '';

                continue;
            }

            $out[] = $line;
        }

        return preg_replace("/\n{3,}/", "\n\n", implode("\n", $out));
    }
}
