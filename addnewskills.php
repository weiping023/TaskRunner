
<!DOCTYPE html>

<?php
  require('debugging.php');
  require('session.php');

  if ($_GET["argument"]=='signOut'){
    logout();
    consoleLog('hi');
  }

  redirectIfNot('tasker');
  
  function showUser() {
    if (isLoggedIn()) {
      echo '
      <div class="ui dropdown inverted button">Hello, '. $_SESSION['userName'] . '</div>
      <div class="ui dropdown inverted button" id="signOut">Sign Out</div>
      ';
      consoleLog($_SESSION['userEmail']);
      consoleLog($_SESSION['userType']);
    } else {
      echo "<a class='ui inverted button' href='/demo/taskeelogin.php'>Log in</a>
      <a class='ui inverted button' href='/demo/taskersignup.php'>Become a Tasker</a>";
    }
  }
?>

<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Homepage - Tasker</title>
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/reset.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/site.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/container.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/grid.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/header.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/image.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/menu.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/divider.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/dropdown.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/segment.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/button.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/list.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/icon.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/sidebar.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/transition.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/label.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/item.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/form.css">

  <script src="assets/jquery-3.3.1.min"></script>
  <script src="semantic/dist/components/transition.js"></script>
  <script src="semantic/dist/components/dropdown.js"></script>

  <script>
    // performs sign out functionality.
    $(document).ready(function() {
      $('#signOut').click(function() {
        $.ajax({
          url: '/demo/taskerdashboard.php?argument=signOut',
          success: function(html){
            location.reload();
          }
        });
      });
    })
  </script>

    <!-- Following script block shows how to get implement autocomplete with suggestions from a local js file-->
  <script>

    var newskill;
    var newskilldesc;

    var newskillJSON;
    var newskilldescJSON;

    var newskillflag = false;
    var newskilldescflag = false;

   $(document).ready(function() {
     $('#adminAddBtn').click(function() {
    //validate inputs
    newskill = $('#newSkill').val();
    newskilldesc = $('#newSkillDesc').val();
    if (newskill == undefined || newskill == '') {
        alert('Please enter skills!');
        newskillflag = true;
      } else {
        newskillflag = false;
      }
    if (newskilldesc == undefined || newskilldesc == '') {
        alert('Please enter skill description!');
        newskilldescflag = true;
      } else {
        newskilldescflag = false;
      }
      if(!newskillflag && !newskilldescflag){
        $('#newSkill').val('');
        $('#newSkillDesc').val('');
        newskillJSON = JSON.stringify(newskill);
        newskilldescJSON = JSON.stringify(newskilldesc);
      $.ajax({
        url: '/demo/addnewskillstodb.php',
        type: 'POST',
        data: { newskill: newskillJSON, newskilldesc: newskilldescJSON},
        dataType: 'json',
        success: function(data) {
          if (data.abc == "failed") {
            alert('Skill already exists');
          } else {
            console.log(data.abc);
            window.location.replace("/demo/admin.php");
          }
        }
      });
    }
  });

   });
  </script>


  <style type="text/css">

    .hidden.menu {
      display: none;
    }

    .masthead.segment {
      min-height: 200px;
      padding: 1em 0em;
    }
    .masthead .logo.item img {
      margin-right: 1em;
    }
    .masthead .ui.menu .ui.button {
      margin-left: 0.5em;
    }
    .masthead h1.ui.header {
      margin-top: 3em;
      margin-bottom: 0em;
      font-size: 4em;
      font-weight: normal;
    }
    .masthead h2 {
      font-size: 1.7em;
      font-weight: normal;
    }

    .ui.vertical.stripe {
      padding: 8em 0em;
    }
    .ui.vertical.stripe h3 {
      font-size: 2em;
    }
    .ui.vertical.stripe .button + h3,
    .ui.vertical.stripe p + h3 {
      margin-top: 3em;
    }
    .ui.vertical.stripe .floated.image {
      clear: both;
    }
    .ui.vertical.stripe p {
      font-size: 1.33em;
    }
    .ui.vertical.stripe .horizontal.divider {
      margin: 3em 0em;
    }

    .quote.stripe.segment {
      padding: 0em;
    }
    .quote.stripe.segment .grid .column {
      padding-top: 5em;
      padding-bottom: 5em;
    }

    .footer.segment {
      padding: 5em 0em;
    }

    .secondary.pointing.menu .toc.item {
      display: none;
    }

    @media only screen and (max-width: 700px) {
      .ui.fixed.menu {
        display: none !important;
      }
      .secondary.pointing.menu .item,
      .secondary.pointing.menu .menu {
        display: none;
      }
      .secondary.pointing.menu .toc.item {
        display: block;
      }
      .masthead.segment {
        min-height: 350px;
      }
      .masthead h1.ui.header {
        font-size: 2em;
        margin-top: 1.5em;
      }
      .masthead h2 {
        margin-top: 0.5em;
        font-size: 1.5em;
      }
    }


  </style>
</head>
<body>

<!-- Page Contents -->
<div class="pusher">
  <div class="ui inverted vertical masthead center aligned segment">

    <div class="ui container">
      <div class="ui large secondary inverted pointing menu">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="active item">Home</a>        
        <a class="item" href="/demo/bidtasks.php">View Available Tasks to Bid</a>
        <a class="item" href="/demo/viewrunningtasks.php">View Tasks I Am Running</a>
        <div class="right item">
          <?php showUser(); ?> 
        </div>
      </div>
    </div>
  </div>


  <div class='ui middle aligned center aligned grid inverted'>
    <div class = 'ui container'> </div> <br>
      <div class='six wide column'>
      <h2 class = 'ui diving header'> Add new Skills </h2>
        <div class = 'ui form'>
          <div class = 'field'>
            <label> New Skill </label>
            <input type = 'text' id='newSkill' placeholder = 'Skill to add'>
          </div> 
          <div class = 'field'>
            <label> Skill Description </label>
            <input type = 'text' id='newSkillDesc' placeholder = 'Describe the Skill'>
          </div>     
          <div class='ui primary button' id=adminAddBtn>Add Skill</div>       
        </div>
      </div>
    </div>
  </div>
</div>
<br><br><br>

<div class="ui inverted vertical footer segment">
  <div class="ui container">
    <div class="ui stackable inverted divided equal height stackable grid">
      <div class="three wide column">
        <h4 class="ui inverted header">Discover</h4>
        <div class="ui inverted link list">
          <a href='/demo/taskeesignup.php' class="item">Sign up to Create Tasks</a>
        </div>
      </div>
      <div class="three wide column">
        
      </div>
      <div class="seven wide column">          
        <h4 class="ui inverted header">Navigate</h4>
        <div class="ui inverted link list">
          <a href='/demo/bidtasks.php' class="item">List of Available Tasks</a>            
          <a href='/demo/viewrunningtasks.php' class="item">My Running Tasks</a>            
        </div>
      </div>
    </div>
  </div>
</div>

</body>

</html>
