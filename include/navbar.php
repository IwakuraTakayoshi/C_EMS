<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/c_ems/index.php">
            C-EMS
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <?php if (isset($_SESSION['host_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/c_ems/index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/c_ems/events/create_events.php">
                            Create Event
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/c_ems/host/logout.php">
                            Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/c_ems/index.php">Home</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
