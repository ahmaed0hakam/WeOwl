<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="app/app.js"></script>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="images/logo/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="images/logo/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="images/logo/favicon-16x16.png"
    />
    <link rel="manifest" href="/site.webmanifest" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css" />
    <title>WeOwl</title>
  </head>
  <body ng-controller="myController">
    <header>
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
          <a href="#" class="navbar-brand"
            ><img src="images/WeOwl.png" alt="WeOwl" width="50px" /> WeOwl</a
          >
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navmenu"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a href="#about" class="nav-link">About</a>
              </li>
              <li class="nav-item">
                <a href="#why-us" class="nav-link">Why Us</a>
              </li>
              <li class="nav-item">
                <div class="" id="navbarNavDarkDropdown">
                  <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                      <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        Login
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                          <a
                            class="dropdown-item"
                            href="users-login/parent/parent-login.php"
                            >As Parent</a
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item"
                            href="users-login/teacher/teacher-login.php"
                            >As Teacher</a
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item"
                            href="users-login/manager/manager-login.php"
                            >As Manager</a
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item"
                            href="users-login/vicemanager/vicemanager-login.php"
                            >As ViceManager</a
                          >
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <section class="section first-section" id="about">
      <video autoplay muted loop id="myVideo">
        <source src="images/girl.mp4" type="video/mp4" />
      </video>
      <h1><span class="welcome">Welcome</span> to WeOwl!</h1>
      <h3>The best site to follow up with your child info at school</h3>
      <div class="content">
        <div class="box">
          <div class="content-show"><h4>What WeOwl is?</h4></div>
          <div class="content-hide">
            <p>
              A website specially designed for parents to follow up with their
              children's information at school.
            </p>
          </div>
        </div>
        <div class="box">
          <div class="content-show"><h4>What classes does it covers?</h4></div>
          <div class="content-hide">
            <p>
              WoOwl specially designed for elementary school students, because
              they are the builders of the future, and we must pay special
              attention to them.
            </p>
          </div>
        </div>
        <div class="box">
          <div class="content-show"><h4>Shld you use WeOwl?</h4></div>
          <div class="content-hide">
            <p>
              Of course you should!
              Your child needs it, you need it.
            </p>
          </div>
        </div>
      </div>
    </section>
    <section class="section second-section" id="why-us">
      <h2>Why Us?</h2>
      <hr />
      <div class="content">
        <div class="title-fr">
          <p>
            This webiste is the first of its kind in Jordan, made by jordanian
            graduates at
            <a href="https://www.just.edu.jo/Pages/Default.aspx"
              >Jordan University of Science and Technology</a
            >. <br />
            Our site has many features, such as Attendance, Academics,
            Communication info, Student data, Teacher names.
          </p>
        </div>

        <div class="secondary-fr">
          <p>
            Attendance<br />
            parents receive notifications when their children arrive at and when
            they leave school.
          </p>
        </div>
        <div class="secondary-fr">
          <p>
            Academics<br />
            parents can keep abreast of everything new, such as their child
            exams, activities and tasks.
          </p>
        </div>
        <div class="secondary-fr">
          <p>
            Communication info<br />
            parents able to see teachers communication info and keep in touch
            with them.
          </p>
        </div>
        <div class="secondary-fr">
          <p>
            Student data<br />
            parents able to see thier children data, such as courses and thair
            info, personal details and etc.
          </p>
        </div>
        <div class="secondary-fr">
          <p>
            Teacher names<br />
            parents able to see thier children's teachers names and other
            details.
          </p>
        </div>
      </div>
    </section>
    <div ng-include="'views/footer.html'"></div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
