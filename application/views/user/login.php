<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in - <?php echo $this->title ; ?></title>
    <link rel="icon" href="<?php echo base_url('favicon.ico') ; ?>" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo base_url('favicon.ico') ; ?>" type="image/x-icon"/>
    <link href="<?php echo base_url('assets/css/tabler.min.css') ; ?>" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/demo.min.css') ; ?>" rel="stylesheet"/>
    <style>
      body {
      	display: none;
      }
    </style>
  </head>
  <body class="antialiased border-top-wide border-primary d-flex flex-column">
    <div class="flex-fill d-flex flex-column justify-content-center">
      <div class="container-tight py-6">
        <form class="card card-md" action="<?php echo base_url('validate') ; ?>" method="post">
          <div class="card-body">
            <h2 class="mb-5 text-center">Booking Management Panel</h2>
            <?php if ($this->input->get('err') == "no_record") { ?>
                <div class="alert alert-danger">
                    <strong>No Record Found!</strong>
                </div>
            <?php }elseif ($this->input->get('err') == "acc_inactive") { ?>
                <div class="alert alert-danger">
                    <strong>Your account is not active!</strong>
                </div>
            <?php }elseif ($this->input->get('err') == "no_login") { ?>
                <div class="alert alert-danger">
                    <strong>You are not logged in!</strong>
                </div>
            <?php }elseif ($this->input->get('err') == "logout") { ?>
                <div class="alert alert-success">
                    <strong>You are logged out successfully!</strong>
                </div>
            <?php }elseif ($this->input->get('err') == "already_login") { ?>
                <div class="alert alert-danger">
                    <strong>User already logged in...!!!</strong>
                </div>
            <?php } ?>
            <div class="mb-3">
              <label class="form-label">User Name</label>
              <input type="text" class="form-control" placeholder="Username" autocomplete="off" name="username" value="<?php echo(isset($_GET['user_name']))?$_GET['user_name']:''; ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input class="form-control" id="password" type="password" placeholder="Password" autocomplete="off" name="password" required>
            </div>
            <div class="form-footer text-center">
              <button type="submit" class="btn btn-primary btn-block"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M20 12h-13l3 -3m0 6l-3 -3" /></svg> Sign in</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="<?php echo base_url('assets/libs/jquery/dist/jquery.slim.min.js') ; ?>"></script>
    <script src="<?php echo base_url('assets/js/tabler.min.js') ; ?>"></script>
    <script src="<?php echo base_url('assets/js/parsley.js') ; ?>"></script>
    <script>
      document.body.style.display = "block"
      $('form').parsley();
    </script>
  </body>
</html>