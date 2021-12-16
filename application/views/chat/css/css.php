
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/favicon.png">
  <title>
    Chat
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="<?php echo base_url()?>assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="<?php echo base_url()?>assets/css/material-dashboard.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <style type="text/css">
      .chat-online {
          color: #34ce57
      }

      .chat-offline {
          color: #e4606d
      }

      .chat-messages {
          display: flex;
          flex-direction: column;
          max-height: 480px;
          overflow-y: scroll
      }

      .chat-message-left,
      .chat-message-right {
          display: flex;
          flex-shrink: 0
      }

      .chat-message-left {
          margin-right: auto
      }

      .chat-message-right {
          flex-direction: row-reverse;
          margin-left: auto
      }
      .py-3 {
          padding-top: 1rem!important;
          padding-bottom: 1rem!important;
      }
      .px-4 {
          padding-right: 1.5rem!important;
          padding-left: 1.5rem!important;
      }
      .flex-grow-0 {
          flex-grow: 0!important;
      }
      .border-top {
          border-top: 1px solid #dee2e6!important;
      }
  </style>
</head>