<?php
function getVerificationEmailHTML($link) {
    return "
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset='UTF-8'>
      <title>Verify Your Email</title>
      <style>
        body {
          background-color: #f4f4f7;
          font-family: Arial, sans-serif;
          padding: 20px;
          color: #333;
        }
        .container {
          background-color: #ffffff;
          max-width: 600px;
          margin: auto;
          border-radius: 8px;
          padding: 30px;
          box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
          color: #2c3e50;
        }
        .button {
          display: inline-block;
          margin-top: 20px;
          padding: 12px 20px;
          background-color: #1d72b8;
          color: #ffffff;
          text-decoration: none;
          border-radius: 6px;
          font-weight: bold;
        }
        .footer {
          margin-top: 30px;
          font-size: 12px;
          color: #888;
          text-align: center;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Welcome to QubeStat!</h2>
        <p>Thanks for signing up. Please verify your email address by clicking the button below:</p>
        <a href='$link' class='button'>Verify Email</a>
        <p>If the button above doesn't work, copy and paste this link into your browser:</p>
        <p><a href='$link'>$link</a></p>
        <div class='footer'>
          <p>If you did not sign up for QubeStat, please ignore this message.</p>
        </div>
      </div>
    </body>
    </html>
    ";
}


function verificationEmailHTML($link) {
    return "
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset='UTF-8'>
      <title>Verify Your Email</title>
      <style>
        body {
          background-color: #f4f4f7;
          font-family: Arial, sans-serif;
          padding: 20px;
          color: #333;
        }
        .container {
          background-color: #ffffff;
          max-width: 600px;
          margin: auto;
          border-radius: 8px;
          padding: 30px;
          box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
          color: #2c3e50;
        }
        .button {
          display: inline-block;
          margin-top: 20px;
          padding: 12px 20px;
          background-color: #1d72b8;
          color: #ffffff;
          text-decoration: none;
          border-radius: 6px;
          font-weight: bold;
        }
        .footer {
          margin-top: 30px;
          font-size: 12px;
          color: #888;
          text-align: center;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Welcome to QubeStat!</h2>
        <p>Please verify your email address to <b>Login</b> to QubeStat:</p>
        <a href='$link' class='button'>Verify Email</a>
        <p>If the button above doesn't work, copy and paste this link into your browser:</p>
        <p><a href='$link'>$link</a></p>
        <div class='footer'>
          <p>If you did not sign up for QubeStat, please ignore this message.</p>
        </div>
      </div>
    </body>
    </html>
    ";
}
?>
