<!-- This webpaqge has been created through the efforts of Charlie Hines,
Taylour Davis, Rob Verdisco, and Geoffrey Wright for James Madison University's
CS 347 Full-Stack Web Development 0001, FA19, Dr. Stewart.

Special Notes:
This page has been developed with the use of bootstrap. The primary factor in
this decision was adherence to mobile-first development responsiveness.
However, bootstrap also allows for uniformaty of style and standard as well
as recently added ARIA accessability features.-->

<?php
session_start();
require_once('../php/login.php');
if(isset($_POST['action']) && $_POST['action'] === 'login') {
  $login_error = login();
}
if(isset($_POST['action']) && $_POST['action'] === 'logoff') {
  session_unset();
  session_destroy();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- Tells internet explorer to use latest rendering engine -->
    <meta http-equiv="X-UA-Compatable" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/fullcalendar.css">
    <link rel="stylesheet" type="text/css" href="../css/dark-mode.css">

    <!-- ///Title Pending/// -->
    <title>TA Homepage</title>

  </head>
  <body>
    <!--Webpage body -->
    <div class="container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <h1>Welcome to the JMU TA system!</h1>
      </div>

      <!-- Page Navigation Bar-->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="../resources/TA_Iconx50px.png" alt="TA Icon"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <div class="btn-group" role="group" aria-label="navigation button group">
                  <a role="help button" type="button" class="btn btn-primary" data-toggle="modal" data-target="#helpModal">Help</a>
                  <a href="index.php" role="home button" type="button" class="btn btn-primary">Home</a>
                  <a href="manager.html" role="manager button" type="button" class="btn btn-primary">Manager Functions</a>
              </div>
            </li>
          </ul>
<?php if(isset($_SESSION['personID'])): ?>
          <form method="post" action="index.php">
            <input type="hidden" name="action" value="logoff">
            <input type="submit" class="btn btn-outline-primary my-2 my-sm-0" value="Logoff">
          </form>
<?php else: ?>
          <button class="btn btn-outline-primary my-2 my-sm-0" type="login"><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></button>
<?php endif; ?>
          <div class="nav-link">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="darkSwitch">
              <label class="custom-control-label" for="darkSwitch">Dark Mode</label>
            </div>
          </div>
        </div>
      </nav>

      <!-- Calendar section -->
      <div class="jumbotron">
        <div id="calendar-container">
          <div id="calendar-header">
            <button class="btn btn-info" id="prevMonth">&lt;</button>
            <span id="calendar-month-year"></span>
            <button class="btn btn-info" id="nextMonth">&gt;</button>
          </div>
          <div id="calendar-dates" class="col-sm-12"></div>
        </div>
      </div>

      <!-- Forum section -->
      <div class="jumbotron">
        <!-- nav search bar -->
        <nav class="navbar navbar-dark bg-dark">
          <h1><a href="#" class="navbar-brand">Question Forum</a></h1>
          <form class="form-inline">
            <input type="text" class="form-control" placeholder="Search">
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
        </nav>
        <nav class="breadcrumb">
          <span class="breadcrumb-item active">Index</span>
        </nav>
        <!-- The section below will begin the dynamic generation
        and management of the question forum. -->
        <!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
        <script>

          /* Below was an attempt to stage activity and allow sequential load */

          // const loadForumIndex = function () {
          //   /* Load the classes to the forum */
          //   fetch('../php/load_forum_classes.php').then((lFCResponse) => {
          //       return lFCResponse.json()
          //     }).then((jsonForums) => {
          //       for (var i = 0; i < jsonForums.length; i++) {
          //         /* create the forum links */
          //         var classRow = document.createElement('tr')
          //         var forumLink = document.createElement('td')
          //         var classHeader = document.createElement('h3')
          //         var classAnchor = document.createElement('a')
          //         classAnchor.innerHTML = `${jsonForums[i].className}`
          //         classAnchor.setAttribute('href', 'javascript:generateClassForum(class); return false;')
          //         classHeader.setAttribute('class', 'h5')
          //         classRow.setAttribute('id', `${jsonForums[i].forumID}`)
          //         classHeader.appendChild(classAnchor)
          //         forumLink.appendChild(classHeader)
          //         classRow.appendChild(forumLink)
          //         forum.appendChild(classRow)
          //       }
          //     }).then(
          //       /* Load question numbar */
          //       fetch('../php/get_question_num.php').then((lNQResponse) => {
          //         return lNQResponse.json()
          //       }).then((jsonNumQ) => {
          //         for (var i = 0; i < jsonNumQ.length; i++) {
          //           /* add number of questions */
          //           var forum = document.getElementById(`${jsonNumQ[i].forumID}`)
          //           var qNumTD = document.createElement('td')
          //           var qNum = document.createElement('div')
          //           qNum.innerHTML = `${jsonNumQ[i].numQuestions}`
          //           qNumTD.appendChild(qNum)
          //           forum.appendChild(qNumTD)
          //         }
          //       }).then(
          //         /* load total posts */
          //         fetch('../php/get_posts_num.php').then((lNPResponse) => {
          //         return lNPResponse.json()
          //         }).then((jsonNumP) => {
          //           for (var i = 0; i < jsonNumP.length; i++) {
          //             /* add number of posts */
          //             var forum = document.getElementById(`${jsonNumP[i].forumID}`)
          //             var pNumTD = document.createElement('td')
          //             var pNum = document.createElement('div')
          //             pNum.innerHTML = `${jsonNumP[i].numPosts}`
          //             pNumTD.appendChild(pNum)
          //             forum.appendChild(pNumTD)
          //           }
          //         }).then(
          //           /* load last questions*/
          //           fetch('../php/get_last_posts.php').then((lLPResponse) => {
          //           return lLPResponse.json()
          //           }).then((jsonLastP) => {
          //             for (var i = 0; i < jsonLastP.length; i++) {
          //               /* add most recent question */
          //               var forum = document.getElementById(`${jsonLastP[i].forumID}`)
          //               var lastPostTD = document.createElement('td')
          //               var post = document.createElement('h4')
          //               var name = document.createElement('div')
          //               var time = document.createElement('div')
          //               post.setAttribute('class', 'h6')
          //               post.innerHTML = `${jsonLastP[i].details}`
          //               name.innerHTML = `${jsonLastP[i].author}`
          //               time.innerHTML = `${jsonLastP[i].asked}`
          //               lastPostTD.appendChild(post)
          //               lastPostTD.appendChild(name)
          //               lastPostTD.appendChild(time)
          //               forum.appendChild(lastPostTD)
          //             }
          //           }).catch(error => {
          //           console.error(error)
          //           })
          //         ).catch(error => {
          //         console.error(error)
          //         })
          //       ).catch(error => {
          //         console.error(error)
          //       })
          //     ).catch(error => {
          //       console.error(error)
          //   })
          // }

          /* The below works, but multiple refreshes may be needed as races can occur
          and procedures must be sequentially done. */

          /* Loads class forum links from the server */
          const loadForumClasses = async () => {
            console.log("load forum classes")
            const lFCResponse = await fetch('../php/load_forum_classes.php')
            const jsonForums = await lFCResponse.json()
            var forum = document.getElementById('forum_body')
            for (var i = 0; i < jsonForums.length; i++) {
              /* create the forum links */
              var classRow = document.createElement('tr')
              var forumLink = document.createElement('td')
              var classHeader = document.createElement('h3')
              var classAnchor = document.createElement('a')
              classAnchor.innerHTML = `${jsonForums[i].className}`
              classAnchor.setAttribute('href', 'javascript:generateClassForum(class); return false;')
              classHeader.setAttribute('class', 'h5')
              classRow.setAttribute('id', `${jsonForums[i].forumID}`)
              classHeader.appendChild(classAnchor)
              forumLink.appendChild(classHeader)
              classRow.appendChild(forumLink)
              forum.appendChild(classRow)
            }
          }

          const loadNumQuestions = async () => {
            console.log("load num questions")
            const lNQResponse = await fetch('../php/get_question_num.php')
            const jsonNumQ = await lNQResponse.json()
            for (var i = 0; i < jsonNumQ.length; i++) {
              /* add number of questions */
              var forum = document.getElementById(`${jsonNumQ[i].forumID}`)
              var qNumTD = document.createElement('td')
              var qNum = document.createElement('div')
              qNum.innerHTML = `${jsonNumQ[i].numQuestions}`
              qNumTD.appendChild(qNum)
              forum.appendChild(qNumTD)
            }
          }

          const loadNumPosts = async () => {
            console.log("load num posts")
            const lNPResponse = await fetch('../php/get_posts_num.php')
            const jsonNumP = await lNPResponse.json()
            for (var i = 0; i < jsonNumP.length; i++) {
              /* add number of posts */
              var forum = document.getElementById(`${jsonNumP[i].forumID}`)
              var pNumTD = document.createElement('td')
              var pNum = document.createElement('div')
              pNum.innerHTML = `${jsonNumP[i].numPosts}`
              pNumTD.appendChild(pNum)
              forum.appendChild(pNumTD)
            }
          }

          const loadLastPosts = async () => {
            console.log("load num posts")
            const lLPResponse = await fetch('../php/get_last_posts.php')
            const jsonLastP = await lLPResponse.json()
            for (var i = 0; i < jsonLastP.length; i++) {
              /* add most recent question */
              var forum = document.getElementById(`${jsonLastP[i].forumID}`)
              var lastPostTD = document.createElement('td')
              var post = document.createElement('h4')
              var name = document.createElement('div')
              var time = document.createElement('div')
              post.setAttribute('class', 'h6')
              post.innerHTML = `${jsonLastP[i].details}`
              name.innerHTML = `${jsonLastP[i].author}`
              time.innerHTML = `${jsonLastP[i].asked}`
              lastPostTD.appendChild(post)
              lastPostTD.appendChild(name)
              lastPostTD.appendChild(time)
              forum.appendChild(lastPostTD)
            }
          }
  
          loadForumClasses() // 1
          loadNumQuestions() // 2
          loadNumPosts()     // 3
          loadLastPosts()    // 4
          // loadForumIndex()
        </script>
    
        <table class="table table-striped table-responsive">
          <thead class="thead-light">
              <tr>
              <th class="col">Forum</th>
              <th class="col">Questions</th>
              <th class="col">Posts</th>
              <th class="col">Last Question</th>
              </tr>
          </thead>
          <tbody id="forum_body">
          </tbody>
        </table>
        <!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
      </div>

      <!-- Login Modal -->
      <div class="modal fade" id="loginModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1>Login</h1>
            </div>
            <form method="post" action="index.php">
              <div class="modal-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>
                    <input type="hidden" name="action" value="login">
<?php if(!empty($login_error)):?>
                    <span class="badge badge-danger"><?php echo $login_error?></span>
<?php endif;?>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
                <button class="btn btn-default" value="Close" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Help Modal -->
      <div class="modal fade" id="helpModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <H1>Help</H1>
              </div>
              <div class="modal-body">
                <p>Need help? This nifty help pop-up will eventually contain
                  istructions on how to use the many features of this web app!
                  For now, this content is to be deternined so all that lies here
                  is dust and the hope of a built future. . .
                </p>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-default" value="Close" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
      </div>
      <!-- Shift Modal -->
      <div class="modal fade" id="shiftModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 id="shiftModal-date"></h1>
            </div>
            <div class="modal-body" id="shiftModal-list"></div>
            <div class="modal-footer">
              <button class="btn btn-default" value="Close" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/calendar.js"></script>
    <script src="../js/dark-mode-switch.js"></script>
<?php if(!empty($login_error)):?>
    <script>
      $(document).ready(function() {
        $('#loginModal').modal('show');
      });
    </script>
<?php endif;?>
  </body>
</html>