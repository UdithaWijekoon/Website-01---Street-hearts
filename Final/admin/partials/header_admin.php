<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        footer {
            padding: 10px;
            text-align: center;
            margin-top: 50px;
        }
        .sidenav {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidenav a, .dropdown-btn {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            outline: none;
            cursor: pointer;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            color: #ffc107;
        }
        .dropdown-container {
            display: none;
            background-color: #495057;
            padding-left: 15px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 767px) {
            .sidenav {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidenav a, .dropdown-btn {
                text-align: center;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Side Navigation Bar -->
    <div class="sidenav">
        <a href="admin.php" class="active"><i class="fas fa-tachometer-alt"></i> Home</a>
        <button class="dropdown-btn"><i class="fas fa-paw"></i> Pet Management
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="admin_pets_list.php">All Pets</a>
            <a href="pending_pets.php">Pending Pets</a>
        </div>
        <button class="dropdown-btn"><i class="fas fa-users"></i> User Management
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="user_management.php">Manage Users</a>
            <a href="view_volunteer_requests.php">Manage Volunteers</a>
            <a href="admin_feedback.php">User Feedback</a>
            <a href="shelter_signup_form.php">Register Shelter</a>
            <a href="admin_signup_form.php">Register Admin</a>
        </div>
        <button class="dropdown-btn"><i class="fa fa-address-card" aria-hidden="true"></i> Adoption Application Management 
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container"> 
            <a href="admin_review_adoptions.php">Review Adoption Application</a>
            <a href="admin_adoption_history.php">Adoption History</a>
        </div>
        <a href="admin_approve_report.php"><i class="fa fa-flag" aria-hidden="true"></i> Report Management</a>
        <button class="dropdown-btn"><i class="fa fa-book" aria-hidden="true"></i> Content Management 
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="admin_manage_content.php">Educational Content Management</a>
            <a href="admin_manage_events.php">Event Management</a>
        </div>
        <a href="admin_view_donations.php"><i class="fas fa-donate"></i> Donations</a>
        <a href="add_location.php"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Add Pet Care Locations</a>
        <button class="dropdown-btn"><i class="fa fa-comments" aria-hidden="true"></i> Messages 
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="admin_messaging_form.php">Send Messages</a>
            <a href="admin_view_messages.php">Received Messages</a>
        </div>
        <a href="terms_conditions.php"><i class="fa fa-check-circle" aria-hidden="true"></i> Terms and Conditions</a>
    </div>
    
    <!-- Main Content -->
    <div class="main-content"> 

        <!-- Header with Dashboard Link and Logout Button -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Admin Dashboard</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <form action="admin_logout.php" method="POST" class="d-inline">
                                <button class="btn btn-outline-danger" type="submit">Logout <i class="fas fa-sign-out-alt"></i></button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>