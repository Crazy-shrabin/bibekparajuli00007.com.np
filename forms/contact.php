<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Replace contact@example.com with your real receiving email address
//   $receiving_email_address = 'contact@example.com';

//   if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
//     include( $php_email_form );
//   } else {
//     die( 'Unable to load the "PHP Email Form" Library!');
//   }

//   $contact = new PHP_Email_Form;
//   $contact->ajax = true;
  
//   $contact->to = $receiving_email_address;
//   $contact->from_name = $_POST['name'];
//   $contact->from_email = $_POST['email'];
//   $contact->subject = $_POST['subject'];

//   // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
//   /*
//   $contact->smtp = array(
//     'host' => 'example.com',
//     'username' => 'example',
//     'password' => 'pass',
//     'port' => '587'
//   );
//   */

//   $contact->add_message( $_POST['name'], 'From');
//   $contact->add_message( $_POST['email'], 'Email');
//   $contact->add_message( $_POST['message'], 'Message', 10);

//   echo $contact->send();
// ?>

<?php
// DB connection settings
$host = 'localhost';
$dbname = 'bibekparajul_db';
$username = 'root';
$password = '';

// Form data
$name    = htmlspecialchars(trim($_POST['name']));
$email   = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$subject = htmlspecialchars(trim($_POST['subject']));
$message = htmlspecialchars(trim($_POST['message']));

// Validate inputs
if (!$name || !$email || !$subject || !$message) {
  http_response_code(400);
  echo "Please fill out all fields correctly.";
  exit;
}

// Connect to DB
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Insert into DB
  $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $email, $subject, $message]);

  echo "Message stored successfully.";

} catch (PDOException $e) {
  http_response_code(500);
  echo "Database error: " . $e->getMessage();
}
?>
