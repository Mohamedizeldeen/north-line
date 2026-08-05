<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Project;
use App\Models\System;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@northline.dev'],
            [
                'name' => 'Ahmed Alsir',
                'password' => bcrypt('password123$'),
                'is_admin' => true,
            ]
        );
        $admin = User::firstOrCreate(
            ['email' => 'eng.mohamed.izeldeen@gmail.com'],
            [
                'name' => 'Mohamed Izeldeen',
                'password' => bcrypt('Mohamed1993$'),
                'is_admin' => true,
            ]
        );

        // ─── Technologies ───────────────────────────────────────
        $technologies = [
            // Backend
            ['name' => 'Laravel',       'slug' => 'laravel',       'category' => 'Backend',   'description' => 'The PHP framework for artisans. Elegant syntax with powerful tools for routing, ORM, and more.', 'sort_order' => 1],
            ['name' => 'PHP',           'slug' => 'php',           'category' => 'Backend',   'description' => 'A widely-used server-side scripting language powering over 75% of websites.', 'sort_order' => 2],
            ['name' => 'Node.js',       'slug' => 'nodejs',        'category' => 'Backend',   'description' => 'JavaScript runtime built on Chrome\'s V8 engine for scalable network applications.', 'sort_order' => 3],
            ['name' => 'Python',        'slug' => 'python',        'category' => 'Backend',   'description' => 'Versatile language used for web development, data science, and automation.', 'sort_order' => 4],
            // Frontend
            ['name' => 'Vue.js',        'slug' => 'vuejs',         'category' => 'Frontend',  'description' => 'Progressive JavaScript framework for building user interfaces and single-page apps.', 'sort_order' => 1],
            ['name' => 'React',         'slug' => 'react',         'category' => 'Frontend',  'description' => 'A JavaScript library for building fast, interactive UIs with a component-based architecture.', 'sort_order' => 2],
            ['name' => 'Tailwind CSS',  'slug' => 'tailwindcss',   'category' => 'Frontend',  'description' => 'Utility-first CSS framework for rapidly building custom designs without writing CSS.', 'sort_order' => 3],
            ['name' => 'Alpine.js',     'slug' => 'alpinejs',      'category' => 'Frontend',  'description' => 'Lightweight JavaScript framework for adding interactivity directly in HTML markup.', 'sort_order' => 4],
            ['name' => 'Livewire',      'slug' => 'livewire',      'category' => 'Frontend',  'description' => 'Full-stack framework for Laravel that makes building dynamic interfaces simple.', 'sort_order' => 5],
            // Database
            ['name' => 'MySQL',         'slug' => 'mysql',         'category' => 'Database',  'description' => 'The world\'s most popular open-source relational database management system.', 'sort_order' => 1],
            ['name' => 'PostgreSQL',    'slug' => 'postgresql',    'category' => 'Database',  'description' => 'Advanced open-source relational database with strong reliability and features.', 'sort_order' => 2],
            ['name' => 'Redis',         'slug' => 'redis',         'category' => 'Database',  'description' => 'In-memory data store used for caching, sessions, and real-time features.', 'sort_order' => 3],
            // DevOps & Tools
            ['name' => 'Docker',        'slug' => 'docker',        'category' => 'DevOps',    'description' => 'Containerization platform for consistent development, testing, and deployment.', 'sort_order' => 1],
            ['name' => 'Git',           'slug' => 'git',           'category' => 'DevOps',    'description' => 'Distributed version control system for tracking changes and team collaboration.', 'sort_order' => 2],
            ['name' => 'Linux',         'slug' => 'linux',         'category' => 'DevOps',    'description' => 'Open-source operating system used to power most web servers worldwide.', 'sort_order' => 3],
            ['name' => 'Nginx',         'slug' => 'nginx',         'category' => 'DevOps',    'description' => 'High-performance web server and reverse proxy for serving web applications.', 'sort_order' => 4],
        ];

        foreach ($technologies as $tech) {
            Technology::firstOrCreate(['slug' => $tech['slug']], $tech);
        }

        // ─── Projects ───────────────────────────────────────────
        $projects = [
            [
                'title' => 'Al-Noor Medical Center Website',
                'slug' => 'al-noor-medical-center',
                'description' => 'A modern, responsive website for a medical center featuring online appointment booking, doctor profiles, department listings, and patient resources.',
                'content' => "Al-Noor Medical Center needed a professional online presence to serve their patients better. We built a comprehensive website with an intuitive appointment booking system, detailed doctor profiles with specializations, and a patient portal for accessing medical resources.\n\nThe site features a clean, accessible design optimized for all devices, ensuring patients can easily find information and book appointments from anywhere. We also integrated a content management system for the clinic staff to update doctor schedules and publish health articles.",
                'client' => 'Al-Noor Medical Center',
                'live_url' => 'https://alnoor-medical.example.com',
                'technologies_used' => ['Laravel', 'Vue.js', 'Tailwind CSS', 'MySQL'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'QuickMart E-Commerce Platform',
                'slug' => 'quickmart-ecommerce',
                'description' => 'Full-featured e-commerce platform with product management, order processing, payment integration, and real-time inventory tracking.',
                'content' => "QuickMart approached us to build a scalable e-commerce platform that could handle thousands of products and high traffic volumes. We delivered a full-stack solution with a powerful admin dashboard, multi-payment gateway integration (Stripe & PayPal), and automated inventory management.\n\nKey features include dynamic product filtering, wishlists, order tracking, email notifications, an analytics dashboard for the business owner, and a mobile-responsive storefront that converts visitors into customers.",
                'client' => 'QuickMart LLC',
                'live_url' => 'https://quickmart.example.com',
                'technologies_used' => ['Laravel', 'React', 'Tailwind CSS', 'MySQL', 'Redis'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'EduTrack Learning Management System',
                'slug' => 'edutrack-lms',
                'description' => 'A comprehensive LMS for schools and training centers with course management, student enrollment, grading, and progress tracking.',
                'content' => "EduTrack is a learning management system we built for educational institutions. It allows administrators to create courses, manage enrollments, track student progress, and generate detailed academic reports.\n\nThe platform supports video lessons, quizzes, assignments, and discussion forums. Teachers get a powerful dashboard to manage their classes, while students enjoy a clean interface to access their learning materials and track their grades.",
                'client' => 'EduTrack Academy',
                'live_url' => 'https://edutrack.example.com',
                'technologies_used' => ['Laravel', 'Livewire', 'Alpine.js', 'PostgreSQL'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Flavor Hub Restaurant Website',
                'slug' => 'flavor-hub-restaurant',
                'description' => 'Modern restaurant website with online menu, table reservations, order-ahead functionality, and integration with delivery services.',
                'content' => "Flavor Hub wanted a website that reflects their brand identity and makes it easy for customers to explore their menu and make reservations. We created a visually stunning site with high-quality food photography, an interactive menu with filtering by category and dietary preferences.\n\nThe reservation system allows customers to book tables online, while the order-ahead feature lets them place takeout orders with estimated pickup times. The admin panel allows the restaurant to update menus, manage reservations, and view order analytics.",
                'client' => 'Flavor Hub Restaurant',
                'live_url' => null,
                'technologies_used' => ['Laravel', 'Vue.js', 'Tailwind CSS', 'MySQL'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'PropertyVault Real Estate Platform',
                'slug' => 'propertyvault-real-estate',
                'description' => 'Real estate listing platform with advanced search, interactive maps, virtual tours, and agent management for a property company.',
                'content' => "PropertyVault is a comprehensive real estate platform designed to streamline property listings and connect buyers with agents. The platform features advanced search with filters for location, price range, property type, and amenities.\n\nWe integrated interactive maps for property locations, supported virtual tour embeds, and built agent profiles with contact forms. The admin dashboard allows property managers to list, edit, and track property inquiries in real time.",
                'client' => 'PropertyVault Group',
                'live_url' => 'https://propertyvault.example.com',
                'technologies_used' => ['Laravel', 'React', 'Tailwind CSS', 'PostgreSQL', 'Redis'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'FitZone Gym Management System',
                'slug' => 'fitzone-gym-management',
                'description' => 'Gym management system with member registration, class scheduling, trainer assignments, payment tracking, and attendance monitoring.',
                'content' => "FitZone needed a centralized system to manage their growing gym operations. We built a complete management platform that handles member registration, subscription plans, class scheduling, and trainer assignments.\n\nThe system includes automated payment reminders, attendance tracking via QR codes, and a member app where users can book classes, track their fitness progress, and communicate with trainers. The admin dashboard provides analytics on membership trends and revenue.",
                'client' => 'FitZone Fitness',
                'live_url' => null,
                'technologies_used' => ['Laravel', 'Livewire', 'Tailwind CSS', 'MySQL'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(['slug' => $project['slug']], $project);
        }

        // ─── Systems / SaaS ─────────────────────────────────────
        $systems = [
            [
                'title' => 'NorthPOS — Point of Sale System',
                'slug' => 'northpos',
                'description' => 'A powerful, easy-to-use point of sale system designed for retail stores, restaurants, and cafés. Manage sales, inventory, employees, and generate real-time reports — all from one dashboard.',
                'content' => "NorthPOS is our flagship point of sale solution built to simplify daily business operations.\n\nKey Features:\n• Fast checkout with barcode scanning and receipt printing\n• Real-time inventory management with low-stock alerts\n• Multi-branch support — manage all your locations from one account\n• Employee management with roles, shifts, and performance tracking\n• Detailed sales reports, daily summaries, and profit analytics\n• Customer loyalty program and discount management\n• Works on tablets, desktops, and touch screens\n\nWhether you run a small shop or a chain of stores, NorthPOS scales with your business. Setup takes less than a day, and our team provides full training and ongoing support.",
                'demo_url' => 'https://demo.northpos.example.com',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'NorthCRM — Customer Relationship Manager',
                'slug' => 'northcrm',
                'description' => 'A smart CRM system to manage your leads, customers, deals, and communications. Track every interaction and close more deals with less effort.',
                'content' => "NorthCRM helps businesses build stronger customer relationships and grow revenue.\n\nKey Features:\n• Lead capture and pipeline management with drag-and-drop Kanban boards\n• Contact management with full interaction history\n• Email integration — send and track emails directly from the CRM\n• Task and follow-up reminders so nothing falls through the cracks\n• Deal tracking with forecasting and win/loss analytics\n• Team collaboration with shared notes and activity feeds\n• Custom fields and workflows to match your business process\n\nNorthCRM is perfect for sales teams, consultancies, and service-based businesses who want to stay organized and close more deals.",
                'demo_url' => 'https://demo.northcrm.example.com',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'NorthHR — Human Resources Management',
                'slug' => 'northhr',
                'description' => 'Complete HR management system for managing employees, attendance, leave requests, payroll, and organizational structure in one place.',
                'content' => "NorthHR streamlines your human resources operations from hiring to retirement.\n\nKey Features:\n• Employee directory with profiles, documents, and contract management\n• Attendance tracking with clock-in/clock-out and overtime calculation\n• Leave management with approval workflows and balance tracking\n• Payroll processing with tax calculations and pay slip generation\n• Department and organizational chart management\n• Performance reviews and goal tracking\n• Self-service portal for employees to view payslips and request leave\n\nNorthHR is ideal for small to mid-size companies looking to digitize their HR processes without the complexity of enterprise solutions.",
                'demo_url' => 'https://demo.northhr.example.com',
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($systems as $system) {
            System::firstOrCreate(['slug' => $system['slug']], $system);
        }

        // ─── Blog Posts ─────────────────────────────────────────
        $posts = [
            [
                'user_id' => $admin->id,
                'title' => 'Why Laravel is Our Go-To Framework for Web Development',
                'slug' => 'why-laravel-is-our-go-to-framework',
                'excerpt' => 'Laravel offers an elegant syntax, powerful tools, and a vibrant ecosystem that makes it the best choice for building modern web applications.',
                'content' => "When it comes to building web applications, choosing the right framework can make or break a project. At North Line, we've worked with many frameworks over the years, but Laravel has consistently proven to be the best choice for our clients and our team.\n\nHere's why:\n\n1. Elegant Syntax\nLaravel's syntax is clean and expressive. It reads almost like natural language, which makes the codebase easier to understand, maintain, and hand off to other developers if needed.\n\n2. Built-in Tools\nAuthentication, routing, database migrations, job queues, email sending — Laravel gives you all of these out of the box. You spend less time reinventing the wheel and more time building features that matter to your business.\n\n3. Eloquent ORM\nInteracting with databases through Eloquent is a joy. Complex queries become simple method chains, and relationships between models are defined clearly and intuitively.\n\n4. Massive Ecosystem\nFrom Nova (admin panels) to Forge (server management) to Vapor (serverless deployment), the Laravel ecosystem has a tool for every part of the application lifecycle.\n\n5. Community & Documentation\nLaravel has one of the largest and most active communities in the PHP world. The documentation is thorough, and there's always someone ready to help when you hit a roadblock.\n\nFor these reasons and more, Laravel remains our framework of choice. If you're planning a web project, we'd love to show you what's possible with Laravel.",
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'The Importance of Mobile-Responsive Design in 2026',
                'slug' => 'importance-of-mobile-responsive-design-2026',
                'excerpt' => 'With over 60% of web traffic coming from mobile devices, responsive design is no longer optional — it\'s essential for business success.',
                'content' => "In 2026, more than 60% of all web traffic comes from mobile devices. If your website doesn't work well on phones and tablets, you're losing customers — it's that simple.\n\nWhat is Responsive Design?\nResponsive design ensures your website adapts smoothly to any screen size. Buttons are easy to tap, text is readable without zooming, and navigation works intuitively on every device.\n\nWhy It Matters\n\n1. User Experience\nVisitors expect seamless experiences. A site that's hard to navigate on mobile will drive people away within seconds. First impressions are everything.\n\n2. SEO Rankings\nGoogle uses mobile-first indexing, meaning it primarily looks at the mobile version of your site when determining search rankings. A non-responsive site will rank lower.\n\n3. Conversion Rates\nStudies show that mobile-friendly websites have significantly higher conversion rates. Whether it's making a purchase, filling out a form, or booking an appointment — responsive design removes friction.\n\n4. Brand Credibility\nA poorly designed mobile experience makes your business look outdated and unprofessional. Investing in responsive design signals quality.\n\nAt North Line, every website we build is fully responsive from day one. We test on real devices across different screen sizes to ensure a perfect experience everywhere.\n\nNeed a responsive website? Let's talk.",
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'user_id' => $admin->id,
                'title' => '5 Signs Your Business Needs a Custom Web Application',
                'slug' => '5-signs-your-business-needs-a-custom-web-app',
                'excerpt' => 'Off-the-shelf software can only take you so far. Here are five signs it\'s time to invest in a custom web application for your business.',
                'content' => "Many businesses start with off-the-shelf tools — and that's perfectly fine. But as your business grows, you may find that generic software no longer fits your needs. Here are five signs it's time to consider a custom web application:\n\n1. You're Using Too Many Disconnected Tools\nIf your team juggles between spreadsheets, multiple SaaS apps, and manual processes to get work done, a custom application can unify everything into one platform.\n\n2. Your Current Software Limits Your Workflow\nOff-the-shelf solutions force you into their way of doing things. If you're constantly working around software limitations instead of working with the software, it's time for something built around YOUR process.\n\n3. You Need Unique Features\nSometimes your business does things differently — and that's your competitive advantage. Custom software lets you build features that no existing tool provides.\n\n4. Security and Compliance Requirements\nIf your industry has strict data handling requirements, a custom application gives you full control over how data is stored, processed, and protected.\n\n5. You're Scaling Rapidly\nGrowth is exciting, but it puts pressure on your tools. Custom applications scale with you — handling more users, more data, and more complexity without breaking.\n\nAt North Line, we specialize in building web applications that solve real business problems. If any of these signs resonate with you, reach out — we'd love to help you find the right solution.",
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'How We Approach Every New Project at North Line',
                'slug' => 'how-we-approach-every-new-project',
                'excerpt' => 'A behind-the-scenes look at our development process — from discovery and planning to development, testing, and launch.',
                'content' => "Every project we take on at North Line follows a proven process designed to deliver results on time and on budget. Here's a look at how we work:\n\nPhase 1: Discovery & Planning\nBefore writing a single line of code, we sit down with you to understand your business, your users, and your goals. We define the project scope, identify key features, and create a detailed roadmap.\n\nPhase 2: Design\nOur designers create wireframes and mockups that bring the project to life visually. You'll see exactly what the final product will look like before development begins. We iterate based on your feedback until the design is perfect.\n\nPhase 3: Development\nWith an approved design in hand, our developers build the application using modern, scalable technologies. We work in sprints, giving you regular updates and demo sessions so you're always in the loop.\n\nPhase 4: Testing\nBefore anything goes live, we rigorously test across devices, browsers, and scenarios. We check for bugs, performance issues, and security vulnerabilities. Your project only launches when it's truly ready.\n\nPhase 5: Launch & Support\nWe handle the deployment and monitor the launch closely. After going live, we provide ongoing support, bug fixes, and feature updates as your business evolves.\n\nThis process has helped us deliver dozens of successful projects. Want to experience it firsthand? Let's start a conversation.",
                'is_published' => true,
                'published_at' => now()->subDays(18),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Choosing Between a Website and a Web Application',
                'slug' => 'choosing-between-website-and-web-application',
                'excerpt' => 'Website or web app? Understanding the difference helps you make the right investment for your business goals.',
                'content' => "We often get asked: \"What's the difference between a website and a web application?\" It's a great question, and the answer determines the kind of solution your business needs.\n\nWebsite\nA website is primarily informational. It presents your brand, showcases your services, displays your portfolio, and provides contact information. Think of it as your digital brochure.\n\nBest for: Small businesses, restaurants, agencies, portfolios, landing pages.\n\nWeb Application\nA web application is interactive and functional. Users log in, perform actions, manage data, and interact with the system. Think of it as software that lives in a browser.\n\nBest for: Dashboards, SaaS products, e-commerce platforms, management systems, booking systems.\n\nWhich One Do You Need?\n\nAsk yourself these questions:\n• Do users need to log in and interact? → Web App\n• Do you primarily need to share information? → Website\n• Do you need to process transactions or manage data? → Web App\n• Is the goal brand awareness and lead generation? → Website\n\nOf course, many businesses need both — a marketing website AND a web application. At North Line, we build both, and we'll help you figure out exactly what you need.\n\nNot sure which direction to go? Reach out, and we'll guide you through it.",
                'is_published' => true,
                'published_at' => now()->subDays(25),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'The Benefits of Having a Point of Sale System for Your Business',
                'slug' => 'benefits-of-pos-system-for-business',
                'excerpt' => 'A modern POS system is more than a cash register — it\'s a complete business management tool that saves time, reduces errors, and boosts profits.',
                'content' => "If you're still relying on manual processes or a basic cash register, you're leaving money and efficiency on the table. Here's why every retail business and restaurant should invest in a modern POS system:\n\n1. Faster Transactions\nPOS systems speed up the checkout process with barcode scanning, quick product lookup, and multiple payment methods. Shorter wait times mean happier customers.\n\n2. Accurate Inventory Management\nEvery sale automatically updates your inventory in real time. You always know what's in stock, what's running low, and what needs to be reordered.\n\n3. Detailed Reporting\nUnderstand your business at a glance. POS systems generate reports on daily sales, top-selling products, peak hours, employee performance, and more.\n\n4. Employee Management\nTrack who's working, manage shifts, and monitor individual performance. Some POS systems even include commission tracking.\n\n5. Customer Insights\nBuild a customer database, track purchase history, and run loyalty programs. Personalized experiences drive repeat business.\n\n6. Reduced Errors\nManual calculations and handwritten records are prone to mistakes. A POS system eliminates human error and ensures accurate records.\n\nOur NorthPOS system is designed for businesses of all sizes. It's affordable, easy to set up, and backed by our dedicated support team. Want to see it in action? Try our live demo or contact us for a walkthrough.",
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::firstOrCreate(['slug' => $post['slug']], $post);
        }

        // ─── Contact Submissions (sample) ───────────────────────
        $contacts = [
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed@example.com',
                'subject' => 'E-Commerce Website Inquiry',
                'message' => "Hi North Line team,\n\nI'm looking to build an e-commerce website for my clothing store. I need product listings, a shopping cart, payment integration, and order management. Can you provide a quote and timeline?\n\nThanks,\nAhmed",
                'status' => 'unread',
            ],
            [
                'name' => 'Sara Mohamed',
                'email' => 'sara.m@example.com',
                'subject' => 'Interested in NorthPOS',
                'message' => "Hello,\n\nI own a small café and I'm interested in your NorthPOS system. I tried the demo and it looks great! I'd like to know the pricing and how long it takes to set up.\n\nBest regards,\nSara",
                'status' => 'unread',
            ],
            [
                'name' => 'Omar Ali',
                'email' => 'omar.ali@example.com',
                'subject' => 'Custom CRM Development',
                'message' => "Hi,\n\nOur company needs a custom CRM that integrates with our existing accounting software. We have about 50 employees and need features for lead tracking, pipeline management, and automated email follow-ups.\n\nCan we schedule a call to discuss this?\n\nOmar Ali\nOperations Manager",
                'status' => 'read',
            ],
        ];

        foreach ($contacts as $contact) {
            ContactSubmission::firstOrCreate(
                ['email' => $contact['email'], 'subject' => $contact['subject']],
                $contact
            );
        }
    }
}
