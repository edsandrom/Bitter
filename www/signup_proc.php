<?php

include("connect.php");
include("Includes/User.php");
?>
<?php

//insert the user's data into the users table of the DB
//if everything is successful, redirect them to the login page.
//if there is an error, redirect back to the signup page with a friendly message
////
if (isset($_POST["firstname"])) {
    $confirm = $_POST["confirm"]; //It's not an user property
    $user = new User();
    $user->setFirstName($_POST["firstname"]);
    $user->setLastName($_POST["lastname"]);
    $user->setEmail($_POST["email"]);
    $user->setUserName($_POST["username"]);
    $user->setPassword($_POST["password"]);
    $user->setContactNo($_POST["phone"]);
    $user->setAddress($_POST["address"]);
    $user->setProvince($_POST["province"]);
    $user->setPostalCode($_POST["postalCode"]);
    $user->setUrl($_POST["url"]);
    $user->setDescription($_POST['desc']);
    $user->setDescription(addslashes($user->getDescription()));
    $user->setLocation($_POST["location"]); //not required
    if (validatePostalCode($user->getPostalCode(), $user->convertProvince($user->getProvince()))) {
        User::signUp($con, $confirm, $user->getFirstName(), $user->getLastName(), $user->getEmail(), $user->getUserName(), $user->getPassword(), $user->getContactNo(),
                $user->getAddress(), $user->getProvince(), $user->getPostalCode(), $user->getUrl(), $user->getDescription(), $user->getLocation());
    } else {
        $msg = "Invalid postal code";
        Header("location:signup.php?msg=$msg");
    }
}//End if(isset)
?>

<?php

function validatePostalCode($userPostalCode, $userProvince) {
    $postalCode = $userPostalCode;//$user->getPostalCode();
    $url = "http://localhost/includes/Fedex/ValidatePostalCodeService/ValidatePostalCodeWebServiceClient.php";
    $cobj = curl_init();
    curl_setopt($cobj, CURLOPT_URL, $url);
    curl_setopt($cobj, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cobj, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($cobj, CURLOPT_POSTFIELDS,
            "PostalCode=" . $postalCode);
    $output = curl_exec($cobj);
    curl_close($cobj);
    $dom = new DOMDocument();
    $dom->loadHTML($output);
    $i = 0;
    $prov = "aaaaaaaaa";
    $result = 0;
    foreach ($dom->getElementsByTagName('td') as $td) {
        if ($i == -2) {
            $prov = $td->nodeValue;
        }
        if ($i == -1) {
            break;
        }
        if ($td->nodeValue == "StateOrProvinceCode") {
            $i = -3;
        }
        $i++;
    }
    if (strtolower($prov) == $userProvince) {/*$user->convertProvince($user->getProvince()*/
        $result = 1; //success
//        echo "success";
    } else {
        $result = 0; //fail
//        echo "fail";
    }
    return $result;
}
?>