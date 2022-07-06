<?

if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                //$name = $_FILES['file']['name'];
                //$ext = explode('.', $_FILES['file']['name']);
                //$filename = $name . '.' . $ext[1];
                $filename = $_FILES['file']['name'];
                $destination = '/opt/lampp/htdocs/dev3/cms/img/' . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                echo 'http://localhost/dev3/cms/img/' . $filename;//change this URL
            }
            else
            {
              echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
            }
        }
