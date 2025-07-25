<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css" />
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img class="img-fluid" src="assets/img/portfolio/logo.png" alt="logo" />

        </div>
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="admin_blog.php">Blog</a></li> 
            <li><a href="admin_skema.php">Skema</a></li> 
        </ul>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h1>Welcome to Admin Dashboard</h1>
                <a href="logout.php" class="signout-btn">Sign Out</a>
            </div>
        </header>

        <section class="stats">
            <div class="card">
                <h3>Total Blogs</h3>
                <p>0</p>
            </div>
            <div class="card">
                <h3>Total Skema</h3>
                <p>0</p>
            </div>
        </section>

        <section class="blog-section">
            <h2>Latest Blogs</h2>
            <div class="blog-list">
                <div class="blog-card">
                    <h3>Blog Title 1</h3>
                    <p class="blog-summary">This is a summary of the first blog...</p>
                    <a href="#">Read more</a>
                </div>
                <div class="blog-card">
                    <h3>Blog Title 2</h3>
                    <p class="blog-summary">This is a summary of the second blog...</p>
                    <a href="#">Read more</a>
                </div>
                <!-- Tambahkan lebih banyak blog di sini -->
            </div>
        </section>

        <section class="schema-section">
            <h2>Skema yang Tersedia</h2>
            <div class="schema-container">
                <div class="schema-card">
                    <h3>Web Development</h3>
                    <p>Skema untuk pengembangan front-end dan back-end.</p>
                </div>
                <div class="schema-card">
                    <h3>UI/UX Design</h3>
                    <p>Skema untuk perancangan antarmuka pengguna dan pengalaman.</p>
                </div>
                <div class="schema-card">
                    <h3>Data Analysis</h3>
                    <p>Skema analisis data dan visualisasi.</p>
                </div>
                <div class="schema-card">
                    <h3>Data Analysis</h3>
                    <p>Skema analisis data dan visualisasi.</p>
                </div>
            </div>
        </section>

</body>

</html>