<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Eskooly</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #4A90E2;
        }

        nav a {
            margin-left: 1.5rem;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #4A90E2;
        }

        .hero {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #E0F7FA, #ffffff);
            text-align: center;
        }

        .hero-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #222;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #555;
        }

        .cta-button {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #357ABD;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 4rem 2rem;
            background: #ffffff;
        }

        .feature-item {
            background: #f1f5f9;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .feature-desc {
            color: #555;
        }

        .about-section {
            padding: 4rem 2rem;
            background: #E3F2FD;
            text-align: center;
        }

        .about-section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #222;
        }

        .about-section p {
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.1rem;
            color: #444;
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            background-color: #f0f0f0;
            color: #666;
            font-size: 0.9rem;
        }

        /* Accessibility outline for keyboard users */
        .user-is-tabbing a:focus,
        .user-is-tabbing button:focus {
            outline: 2px solid #4A90E2;
            outline-offset: 2px;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            nav {
                margin-top: 1rem;
            }

            nav a {
                margin: 0.5rem 0;
                display: inline-block;
            }
        }
    </style>

</head>

<body>
    <header>
        <div class="logo">Eskooly</div>
        <nav role="navigation" aria-label="Primary navigation">
            <a href="#features" tabindex="0">Features</a>
            <a href="#about" tabindex="0">About</a>
            <a href="public/login.php">login</a>
            <a href="public/signup.php">signup</a>
        </nav>
    </header>
    <main role="main">
        <section class="hero" aria-label="Welcome section">
            <h1 class="hero-title">Streamline Your School Management</h1>
            <p class="hero-subtitle">Effortlessly manage students, teachers, classes, and schedules all in one modern platform.</p>
            <button class="cta-button" onclick="window.location.href='public/signup.php'">Get Started</button>
        </section>

        <section class="features" id="features" aria-label="Key features">
            <article class="feature-item" tabindex="0">
                <div class="feature-icon" aria-hidden="true">📚</div>
                <h3 class="feature-title">Classroom Management</h3>
                <p class="feature-desc">Organize classes, assign teachers, and track attendance seamlessly.</p>
            </article>
            <article class="feature-item" tabindex="0">
                <div class="feature-icon" aria-hidden="true">👨‍🏫</div>
                <h3 class="feature-title">Teacher Portal</h3>
                <p class="feature-desc">Empower teachers with communication tools and grading systems.</p>
            </article>
            <article class="feature-item" tabindex="0">
                <div class="feature-icon" aria-hidden="true">📅</div>
                <h3 class="feature-title">Schedule Automation</h3>
                <p class="feature-desc">Automate class schedules and notifications efficiently.</p>
            </article>
        </section>

        <section class="about-section" id="about" aria-label="About School Management System">
            <h2>About SchoolSys</h2>
            <p>SchoolSys is a comprehensive school management system designed to simplify administrative tasks, enhance communication, and promote effective learning environments.</p>
        </section>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> SchoolSys. All rights reserved.
    </footer>
    <script>
        // Accessibility: focus visible outline handling
        document.addEventListener('keydown', function(e) {
            if (e.key === "Tab") {
                document.body.classList.add('user-is-tabbing');
            }
        });
        document.addEventListener('mousedown', function(e) {
            document.body.classList.remove('user-is-tabbing');
        });
    </script>
</body>

</html>