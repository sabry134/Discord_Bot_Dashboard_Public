<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Template</title>
    <style>
        body {
            background-image: url('admin/img/dashboard_bg.gif');
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: Arial, sans-serif;
        }
        .content {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border-radius: 10px;
            color: black;
        }
        .admin-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #7289DA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .about-btn {
            position: absolute;
            top: 10px;
            right: 110px;
            background-color: #7289DA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .get-started-btn {
            background-color: #7289DA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <a href="http://localhost:8080/admin" class="admin-btn">Admin</a>
    <a href="http://localhost:8080/about.json" class="about-btn">About</a>
    <div class="content">
        <h1>Welcome to the Dashboard template</h1>
        <p>This your dashboard template main page</p>
        <p>Made with ❤️ by Sabry and mjmj5558</p>
        <a href="http://localhost:8080/user" class="get-started-btn">Get Started</a>
    </div>
</body>
</html>
