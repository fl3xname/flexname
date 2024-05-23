

<?php
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
    // Retrieve form data
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $comment = $_POST['comment'];
    
    

    // Prepare headers for email
    $to = "fl3xname@gmail.com";
    $subject = "flexname";
    $headers = "From: info@flexname.fun\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";
    
    // Message content
    $message = "Name: $name\nGmail: $mail\nComment: $comment\n";
    
    // Initialize body of the email
    $body = "--boundary\r\n";
    $body .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= $message."\r\n";
    
    // Process uploaded files
    if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'][0])) {
        foreach($_FILES['photo']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['photo']['name'][$key];
            $file_tmp = $_FILES['photo']['tmp_name'][$key];
            
            // Read the file content
            $file_content = file_get_contents($file_tmp);
            
            // Encode file content to base64
            $file_base64 = base64_encode($file_content);
            
            // Attach file to email
            $body .= "--boundary\r\n";
            $body .= "Content-Type: application/octet-stream; name=\"$file_name\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
            $body .= chunk_split($file_base64)."\r\n";
        }
    }
    
    // Close email boundary
    $body .= "--boundary--";
    
    // Send email
    mail($to, $subject, $body, $headers);
}
?>

