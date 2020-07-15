<?php

/**
 * Description of User
 *
 * @author Edsandro de Oliveira <edsandrom@gmail.com>
 */
class User {

//Integer
    protected $userId;
//String
    protected $Password, $LastName, $Province, $ContactNo, $DateAdded, $Location, $url, $UserName, $FirstName, $Address, $postalCode,
            $email, $profImage, $description;

//Constructor
    function __construct() {
        
    }

//Getters and Setters
    function getUserId() {
        return $this->userId;
    }

    function getPassword() {
        return $this->Password;
    }

    function getLastName() {
        return $this->LastName;
    }

    function getProvince() {
        return $this->Province;
    }

    function getContactNo() {
        return $this->ContactNo;
    }

    function getDateAdded() {
        return $this->DateAdded;
    }

    function getLocation() {
        return $this->Location;
    }

    function getUrl() {
        return $this->url;
    }

    function getUserName() {
        return $this->UserName;
    }

    function getFirstName() {
        return $this->FirstName;
    }

    function getAddress() {
        return $this->Address;
    }

    function getPostalCode() {
        return $this->postalCode;
    }

    function getEmail() {
        return $this->email;
    }

    function getProfImage() {
        return $this->profImage;
    }

    function getDescription() {
        return $this->description;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setPassword($Password) {
        $this->Password = $Password;
    }

    function setLastName($LastName) {
        $this->LastName = $LastName;
    }

    function setProvince($Province) {
        $this->Province = $Province;
    }

    function setContactNo($ContactNo) {
        $this->ContactNo = $ContactNo;
    }

    function setDateAdded($DateAdded) {
        $this->DateAdded = $DateAdded;
    }

    function setLocation($Location) {
        $this->Location = $Location;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setUserName($UserName) {
        $this->UserName = $UserName;
    }

    function setFirstName($FirstName) {
        $this->FirstName = $FirstName;
    }

    function setAddress($Address) {
        $this->Address = $Address;
    }

    function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setProfImage($profImage) {
        $this->profImage = $profImage;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    static function userFollowsAnother($userId1, $userId2, $con) {
        if ($userId1 != $userId2) {
            $sql = "SELECT follow_id FROM follows WHERE from_id = $userId1 AND to_id = $userId2";
            $rs = mysqli_query($con, $sql)
                    or die($sql . " : " . mysqli_connect_error());
            $result = mysqli_num_rows($rs);
            if ($result != 0) {
                echo 'Following';
            } else {
                echo '<form method="post" id="follow_form" action="follow_proc.php">
                                        <input type="hidden" name="userID" id="button" value="' . $userId2 . '"/>
                                        <input type="submit" name="followButton" id="button" value="Follow" class="btn btn-primary btn-sm"/>
                            </form>';
            }
        } else {
            echo 'It\'s you!';
            echo '<BR>';
        }
    }

    static function anotherFollowsUser($userId2, $userId1, $con) {
        if ($userId1 != $userId2) {
            $sql = "SELECT follow_id FROM follows WHERE from_id = $userId1 AND to_id = $userId2";
            $rs = mysqli_query($con, $sql)
                    or die($sql . " : " . mysqli_connect_error());
            $result = mysqli_num_rows($rs);
            if ($result != 0) {
                echo 'Follows You';
            } else {
                echo '';
            }
        } else {
            echo 'It\'s you!';
            echo '<BR>';
        }
    }

    static function bothFollows($loggedUserId, $userId, $con) {
        $counter = 3;
        $sql = "SELECT DISTINCT u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic FROM users u "
                . "INNER JOIN follows f ON u.user_id = f.to_id "
                . "WHERE f.to_id IN (SELECT to_id FROM follows WHERE from_id =" . $loggedUserId . ") AND "
                . "f.to_id IN (SELECT to_id FROM follows WHERE from_id =" . $userId . ") ORDER BY RAND() LIMIT $counter";

        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        return $rs;
    }

    static function followedYouKnow($loggedUserId, $userId, $con) {
        $sql = "SELECT DISTINCT u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic FROM users u "
                . "INNER JOIN follows f ON u.user_id = f.to_id "
                . "WHERE f.to_id IN (SELECT to_id FROM follows WHERE from_id =" . $loggedUserId . ") AND "
                . "f.to_id IN (SELECT to_id FROM follows WHERE from_id =" . $userId . ") ORDER BY RAND()";

        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        return $rs;
    }

    static function searchUsers($word, $con) {
        $sql = "SELECT user_id, first_name, last_name, screen_name FROM users WHERE screen_name LIKE '%" . $word . "%' "
                . "OR first_name LIKE '%" . $word . "%' OR last_name LIKE '%" . $word . "%'";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        return $rs;
    }

    function getProfilePic($userId, $con) {
        $sql = "SELECT profile_pic FROM users WHERE user_id = '" . $userId . "'";
        $picRS = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        $profilePicArray = mysqli_fetch_array($picRS); //It has only one result
        $profilePic = $profilePicArray['profile_pic'];
        return $profilePic;
    }

    function countTweets($userId, $con) {
        $count = 0;
        $sql = "SELECT tweet_id FROM tweets WHERE reply_to_tweet_id = 0 AND user_id = '" . $userId . "'";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        while (mysqli_fetch_array($rs)) {
            $count++;
        }
        return $count;
    }

    function countFollowing($userId, $con) {
        $count = 0;
        $sql = "SELECT follow_id FROM follows WHERE from_id = '" . $userId . "'";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        while (mysqli_fetch_array($rs)) {
            $count++;
        }
        return $count;
    }

    function countFollowed($userId, $con) {
        $count = 0;
        $sql = "SELECT follow_id FROM follows WHERE to_id = '" . $userId . "'";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        while (mysqli_fetch_array($rs)) {
            $count++;
        }
        return $count;
    }

    function setAll($userId, $con) {
        $user = new User();
        $sql = "SELECT * from users where user_id =" . $userId;
        $record = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        $rs = mysqli_fetch_array($record);
        $user->setUserId($userId);
        $user->setFirstName($rs['first_name']);
        $user->setLastName($rs['last_name']);
        $user->setUserName($rs['screen_name']);
        $user->setPassword($rs['password']);
        $user->setAddress($rs['address']);
        $user->setPostalCode($rs['postal_code']);
        $user->setContactNo($rs['contact_number']);
        $user->setEmail($rs['email']);
        $user->setUrl($rs['url']);
        $user->setDescription($rs['description']);
        $user->setLocation($rs['location']);
        $user->setDateAdded($rs['date_created']);
        $user->setProfImage($rs['profile_pic']);

        return $user;
    }

    function checkLogin($password, $username, $con) {
//Select from users table
        $selectStatement = "SELECT `user_id`, `first_name`, `last_name`, `screen_name`, `password` FROM `users`"
                . " WHERE `screen_name` = '" . $username . "'";
//            . " AND MD5(`password`) = MD5('$pass')";// --> MD5 for case-sensitive checking
        $recordSet = mysqli_query($con, $selectStatement)
                or die($selectStatement . " : " . mysqli_connect_error()); //Executes query
        if (mysqli_num_rows($recordSet) == 1) {
            $selectSql = mysqli_fetch_array($recordSet);
            if (password_verify($password, $selectSql['password'])) { //Verifies if the password is correct --> Encrypted Password
                $_SESSION['SESS_FIRST_NAME'] = $selectSql['first_name'];
                $_SESSION['SESS_LAST_NAME'] = $selectSql['last_name'];
                $_SESSION['SESS_MEMBER_ID'] = $selectSql['user_id'];
                $msg = "Login Successful";
                Header("location:index.php?msg=$msg");
            } else {
                $msg = "The password entered is incorrect.";
                Header("location:login.php?msg=$msg");
            }
        } else { //(mysqli_affected_rows != 1)
            $msg = "Sorry, the data entered is incorrect. Please try again.";
            Header("location:login.php?msg=$msg");
        }//end affected rows verification ELSE
    }

    static function followUser($followingUserId, $followedUserId, $con) {
//Check if user1 follows user2 already
        $sqlFollow = "SELECT `from_id`, `to_id` FROM `follows` WHERE `from_id` = " . $followingUserId . " AND `to_id`= " . $followedUserId;
        $recordSet = mysqli_query($con, $sqlFollow)
                or die($sqlFollow . " : " . mysqli_connect_error($con)); //Executes query
        if (mysqli_num_rows($recordSet) == 0) {
//Insert into table  
            $sql = "INSERT INTO `follows` (`from_id`, `to_id`) VALUES (" . $followingUserId . ", " . $followedUserId . ")";
            mysqli_query($con, $sql);

            if (mysqli_affected_rows($con) == 1) {
                $msg = "Now you are following the user.";
            } else {
//            $msg = "Error on your request. Please try again.";
                $msg = $sql;
            }
        } else {
            $msg = "You are already following this user.";
        }
        Header("location:index.php?msg=$msg");
    }

    static function editPhoto($userId, $con) {
        $target_dir = "Images/profilepics/";
        $target_file = $target_dir . basename($_FILES["photoUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $newPathFile = $target_dir . $userId . "." . $imageFileType;
        $newFileName = $userId . "." . $imageFileType;
        $uploadOk = 0;
        if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], $newPathFile)) {
            $uploadOk = 1;
        }
        $sqlOld = "SELECT profile_pic FROM users WHERE user_id = '" . $userId . "'";
        $oldRecordSet = mysqli_query($con, $sqlOld)
                or die($sqlOld . " : " . mysqli_connect_error());
        $oldFileNameSet = mysqli_fetch_array($oldRecordSet); //It has only one result
        $oldFileName = $oldFileNameSet['profile_pic'];
        $oldFileDir = $target_dir . $oldFileName;
        if ($uploadOk == 1) {
            $sqlUpdate = "UPDATE `users` SET `profile_pic`= '$newFileName' WHERE `user_id` = '" . $userId . "'";
            $recordSet = mysqli_query($con, $sqlUpdate)
                    or die($sqlUpdate . " : " . mysqli_connect_error());
            if ($recordSet && $uploadOk == 1) {//Checking if the query was successful and if the picture was saved on server
                if ($oldFileName != $newFileName) { //checking if pics names are different --- Looking for extensions
                    $dirHandle = opendir($target_dir);
                    while ($file = readdir($dirHandle)) {
                        if ($file == $oldFileName && $oldFileName != "default.jfif") {
                            unlink($target_dir . $oldFileName); //Deletes old file
                        }
                    }
                }
                $msg = "The " . basename($_FILES["photoUpload"]["name"]) . " image has been uploaded.";
            } else {
                $msg = "Sorry, there was an error uploading your image.";
            }
        }
        Header("location:index.php?msg=$msg");
    }

    static function displayTop3($userId, $con) {
//TOP 3
        $counter = 3; //Number of users to be shown
        $notIn = "SELECT to_id FROM follows WHERE from_id = '" . $userId . "'";
        $sqlStatement = "SELECT `user_id`, `first_name`, `last_name`, `screen_name`,`profile_pic` "
                . "FROM `users` WHERE `user_id` != '" . $userId . "' AND user_id NOT IN ($notIn) ORDER BY RAND() LIMIT $counter";
        $recordSet = mysqli_query($con, $sqlStatement)
                or die($sqlStatement . " : " . mysqli_error($con)); //Executes query
        while ($top3Sql = mysqli_fetch_array($recordSet)) {
            $dispUser = new User();
            $dispUser->setUserId($top3Sql['user_id']); //User
            $dispUser->setFirstName($top3Sql['first_name']); //User
            $dispUser->setLastName($top3Sql['last_name']); //User
            $dispUser->setUserName($top3Sql['screen_name']); //User
            $dispUser->setProfImage($top3Sql['profile_pic']); //User
            echo
            '<form method="post" id="follow_form" action="follow_proc.php">
                                <div class="column2">
                                    <div class="whoToTroll img-rounded">
                                        <!-- display people you may know here-->
                                        <img class="img-thumbnail" src="images/profilepics/' . $dispUser->getProfImage() . '">
                                        <a href="userpage.php?user_id=' . $dispUser->getUserId() . '">' . $dispUser->getFirstName() . " " . $dispUser->getLastName() . " @" . $dispUser->getUserName() . '</a><BR></div>
                                        <div class="form-group">
                                        <input type="hidden" name="userID" id="button" value="' . $dispUser->getUserId() . '"/>
                                        <input type="submit" name="followButton" id="button" value="Follow" class="btn btn-primary btn-sm"/>
                                        <hr></hr>
                                    </div>
                                </div>
                            </form>';
        }
    }

    static function displayTweets($userId, $con) {
        $tweetsCounter = 10; //Limit amount of tweets being displayed
        $defaultReplyToTweetId = 0; //Default to check if the tweet is a reply or not --> Replies will not be shown as tweets, they will be shown as replies only
        $sqlTweet = "SELECT DISTINCT users.first_name, users.last_name, users.screen_name, users.user_id, "
                . "tweets.tweet_text, tweets.tweet_id, tweets.reply_to_tweet_id, tweets.original_tweet_id, tweets.date_created, tweets.user_id "
                . "FROM users users "
                . "INNER JOIN tweets tweets ON users.user_id = tweets.user_id "
                . "INNER JOIN follows follows ON tweets.user_id = follows.to_id "
                . "WHERE (tweets.user_id = '" . $userId . "' OR tweets.user_id IN "
                . "(SELECT follows.to_id FROM follows follows WHERE follows.from_id = '" . $userId . "'))"
                . "AND tweets.reply_to_tweet_id ='" . $defaultReplyToTweetId . "' "
                . "ORDER BY tweets.date_created DESC "
                . "LIMIT $tweetsCounter";
        $tweetsRS = mysqli_query($con, $sqlTweet)
                or die($sqlTweet . " : " . mysqli_error($con));
        while ($tweets = mysqli_fetch_array($tweetsRS)) {
//Creating Objects and setting attributes
            $twUser = new User();
            $twTweet = new Tweet();
            $twTweet->setTweetText($tweets['tweet_text']); //Tweet
            $twTweet->setTweetId($tweets['tweet_id']); //Tweet
            $twTweet->setDateAdded($tweets['date_created']); //Tweet
            $twTweet->setOriginalTweetId($tweets['original_tweet_id']); //Tweet
            $twTweet->setReplytoTweetId($tweets['reply_to_tweet_id']);
            $twUser->setFirstName($tweets['first_name']); //User
            $twUser->setLastName($tweets['last_name']); //User
            $twUser->setUserName($tweets['screen_name']); //User
            $twUser->setUserId($tweets['user_id']); //User
//Getting the tweeted period
            $now = new DateTime();
            $tweetTime = new DateTime($twTweet->getDateAdded());
            $interval = $tweetTime->diff($now);
            if ($interval->y > 1)
                $period = $interval->format('%y years') . " ago";
            elseif ($interval->y > 0)
                $period = $interval->format('%y year') . " ago";
            elseif ($interval->m > 1)
                $period = $interval->format('%m months') . " ago";
            elseif ($interval->m > 0)
                $period = $interval->format('%m month') . " ago";
            elseif ($interval->d > 1)
                $period = $interval->format('%d days') . " ago";
            elseif ($interval->d > 0)
                $period = $interval->format('%d day') . " ago";
            elseif ($interval->h > 1)
                $period = $interval->format('%h hours') . " ago";
            elseif ($interval->h > 0)
                $period = $interval->format('%h hour') . " ago";
            elseif ($interval->i > 1)
                $period = $interval->format('%i minutes') . " ago";
            elseif ($interval->i > 0)
                $period = $interval->format('%i minute') . " ago";
            elseif ($interval->s > 1)
                $period = $interval->format('%s seconds') . " ago";
            elseif ($interval->s > 0)
                $period = $interval->format('%s second') . " ago";
            else
                $period = "just now";
//Creating/Displaying tweets
            if ($twTweet->getOriginalTweetId() != 0) {//Checks if it's a retweet
                $rtUser = new User();
                $sqlSt = "SELECT u.user_id, u.first_name, u.last_name "
                        . "FROM users u INNER JOIN tweets t ON t.user_id = u.user_id "
                        . "WHERE t.tweet_id = '" . $twTweet->getOriginalTweetId() . "'";
                $resultSet = mysqli_query($con, $sqlSt)
                        or die($sqlSt . " : " . mysqli_error($con)); //Executes query
                $result = mysqli_fetch_array($resultSet);
                $rtUser->setFirstName($result['first_name']);
                $rtUser->setLastName($result['last_name']);
//
//                                        Checking if there's any reply to this tweet
//
                $replySt = "SELECT u.user_id, u.first_name, u.last_name, u.screen_name, t.tweet_id, t.tweet_text, t.date_created "
                        . "FROM users u INNER JOIN tweets t ON t.user_id = u.user_id "
                        . "WHERE t.reply_to_tweet_id = '" . $twTweet->getTweetId() . "'";
                $rws = mysqli_query($con, $replySt)
                        or die($replySt . " : " . mysqli_error($con)); //Executes query
//
//selection like icon
//
                if ($twTweet->likedTweet($con, $twTweet->getTweetId(), $userId) == 1) {
                    $likeIcon = "like.png";
                } else {
                    $likeIcon = "liked.png";
                }
//
//Counting likes
//
                $likesCount = Tweet::countLikes($con, $twTweet->getTweetId());
                echo
                '
                                        <div class="container">
                                            <a href="userpage.php?user_id=' . $twUser->getUserId() . '">' .
                $twUser->getFirstName() . " " . $twUser->getLastName() . " @" . $twUser->getUserName() . " " . '</a>' . $period .
                ' <span style="font-weight: bold;">retweeted from ' . $rtUser->getFirstName() . ' ' . $rtUser->getLastName() . ' </span>   
                                            <h5>' . $twTweet->getTweetText() . '</h5>
                                            <BR>
                                            <a href="LikeTweet.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/' . $likeIcon . '">
                                            </a>
                                            ' . $likesCount . '
                                            <a href="Retweet.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/retweet.png">
                                            </a>
                                            <a href="Reply.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/reply.png">
                                            </a>
                                            ';
                if (mysqli_num_rows($rws) != 0) {
                    while ($record = mysqli_fetch_array($rws)) {
                        $usReplier = new User();
                        $twReplier = new Tweet();
                        $usReplier->setUserId($record['user_id']);
                        $usReplier->setFirstName($record['first_name']);
                        $usReplier->setLastName($record['last_name']);
                        $usReplier->setUserName($record['screen_name']);
                        $twReplier->setTweetId($record['tweet_id']);
                        $twReplier->setTweetText($record['tweet_text']);
                        $twReplier->setDateAdded($record['date_created']);
//Getting the reply period
                        $now = new DateTime();
                        $replyTime = new DateTime($twReplier->getDateAdded());
                        $intervalReply = $replyTime->diff($now);
                        if ($intervalReply->y > 1)
                            $periodReply = $intervalReply->format('%y years') . " ago";
                        elseif ($intervalReply->y > 0)
                            $periodReply = $intervalReply->format('%y year') . " ago";
                        elseif ($intervalReply->m > 1)
                            $periodReply = $intervalReply->format('%m months') . " ago";
                        elseif ($intervalReply->m > 0)
                            $periodReply = $intervalReply->format('%m month') . " ago";
                        elseif ($intervalReply->d > 1)
                            $periodReply = $intervalReply->format('%d days') . " ago";
                        elseif ($intervalReply->d > 0)
                            $periodReply = $intervalReply->format('%d day') . " ago";
                        elseif ($intervalReply->h > 1)
                            $periodReply = $intervalReply->format('%h hours') . " ago";
                        elseif ($intervalReply->h > 0)
                            $periodReply = $intervalReply->format('%h hour') . " ago";
                        elseif ($intervalReply->i > 1)
                            $periodReply = $intervalReply->format('%i minutes') . " ago";
                        elseif ($intervalReply->i > 0)
                            $periodReply = $intervalReply->format('%i minute') . " ago";
                        elseif ($intervalReply->s > 1)
                            $periodReply = $intervalReply->format('%s seconds') . " ago";
                        elseif ($intervalReply->s > 0)
                            $periodReply = $intervalReply->format('%s second') . " ago";
                        else
                            $periodReply = "just now";
//
//selection like icon
//
                        if ($twTweet->likedTweet($con, $twReplier->getTweetId(), $userId) == 1) {
                            $likeIcon = "like.png";
                        } else {
                            $likeIcon = "liked.png";
                        }
//
//Counting likes
//
                        $likesCount = Tweet::countLikes($con, $twReplier->getTweetId());
                        echo
                        '
                                            <div class="container">
                                            <BR>
                                            <a href="userpage.php?user_id=' . $usReplier->getUserId() . '">' .
                        $usReplier->getFirstName() . " " . $usReplier->getLastName() . " @" . $usReplier->getUserName() . " " . '</a> <span style="font-weight: bold;">replied </span>' . $periodReply .
                        '   
                                            <h5>' . $twReplier->getTweetText() . '</h5>
                                            <BR>
                                            <a href="LikeTweet.php?tweetId=' . $twReplier->getTweetId() . '">
                                            <img class="bannericons" src="Images/' . $likeIcon . '">
                                            </a>
                                            ' . $likesCount . '
                                            <a href="Retweet.php?tweetId=' . $twReplier->getTweetId() . '">
                                            <img class="bannericons" src="Images/retweet.png">
                                            </a>
                                            <a href="Reply.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/reply.png">
                                            </a>
                                            </div>
                                            ';
                    }
                }
                echo
                '
                                            <hr>
                                            </div>';
            } else {
                $replySt = "SELECT u.user_id, u.first_name, u.last_name, u.screen_name, t.tweet_id, t.tweet_text, t.date_created "
                        . "FROM users u INNER JOIN tweets t ON t.user_id = u.user_id "
                        . "WHERE t.reply_to_tweet_id = '" . $twTweet->getTweetId() . "'";
                $rws = mysqli_query($con, $replySt)
                        or die($replySt . " : " . mysqli_error($con)); //Executes query
//
//selection like icon
//
                if ($twTweet->likedTweet($con, $twTweet->getTweetId(), $userId) == 1) {
                    $likeIcon = "like.png";
                } else {
                    $likeIcon = "liked.png";
                }
//
//Counting likes
//
                $likesCount = Tweet::countLikes($con, $twTweet->getTweetId());
                echo
                '
                                        <div class="container">
                                            <a href="userpage.php?user_id=' . $twUser->getUserId() . '">' .
                $twUser->getFirstName() . " " . $twUser->getLastName() . " @" . $twUser->getUserName() . " " . '</a>' . $period . '    
                                            <h5>' . $twTweet->getTweetText() . '</h5>
                                            <BR>
                                            <a href="LikeTweet.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/' . $likeIcon . '">
                                            </a>
                                            ' . $likesCount . '
                                            <a href="Retweet.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/retweet.png">
                                            </a>
                                            <a href="Reply.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/reply.png">
                                            </a>
                                            ';
                if (mysqli_num_rows($rws) != 0) {
                    while ($record = mysqli_fetch_array($rws)) {
                        $usReplier = new User();
                        $twReplier = new Tweet();
                        $usReplier->setUserId($record['user_id']);
                        $usReplier->setFirstName($record['first_name']);
                        $usReplier->setLastName($record['last_name']);
                        $usReplier->setUserName($record['screen_name']);
                        $twReplier->setTweetId($record['tweet_id']);
                        $twReplier->setTweetText($record['tweet_text']);
                        $twReplier->setDateAdded($record['date_created']);
//Getting the reply period
                        $now = new DateTime();
                        $replyTime = new DateTime($twReplier->getDateAdded());
                        $intervalReply = $replyTime->diff($now);
                        if ($intervalReply->y > 1)
                            $periodReply = $intervalReply->format('%y years') . " ago";
                        elseif ($intervalReply->y > 0)
                            $periodReply = $intervalReply->format('%y year') . " ago";
                        elseif ($intervalReply->m > 1)
                            $periodReply = $intervalReply->format('%m months') . " ago";
                        elseif ($intervalReply->m > 0)
                            $periodReply = $intervalReply->format('%m month') . " ago";
                        elseif ($intervalReply->d > 1)
                            $periodReply = $intervalReply->format('%d days') . " ago";
                        elseif ($intervalReply->d > 0)
                            $periodReply = $intervalReply->format('%d day') . " ago";
                        elseif ($intervalReply->h > 1)
                            $periodReply = $intervalReply->format('%h hours') . " ago";
                        elseif ($intervalReply->h > 0)
                            $periodReply = $intervalReply->format('%h hour') . " ago";
                        elseif ($intervalReply->i > 1)
                            $periodReply = $intervalReply->format('%i minutes') . " ago";
                        elseif ($intervalReply->i > 0)
                            $periodReply = $intervalReply->format('%i minute') . " ago";
                        elseif ($intervalReply->s > 1)
                            $periodReply = $intervalReply->format('%s seconds') . " ago";
                        elseif ($intervalReply->s > 0)
                            $periodReply = $intervalReply->format('%s second') . " ago";
                        else
                            $periodReply = "just now";
//
//selection like icon
//
                        if ($twTweet->likedTweet($con, $twReplier->getTweetId(), $userId) == 1) {
                            $likeIcon = "like.png";
                        } else {
                            $likeIcon = "liked.png";
                        }
//
//Counting likes
//
                        $likesCount = Tweet::countLikes($con, $twReplier->getTweetId());
                        echo
                        '
                                            <div class="container">
                                            <BR>
                                            <a href="userpage.php?user_id=' . $usReplier->getUserId() . '">' .
                        $usReplier->getFirstName() . " " . $usReplier->getLastName() . " @" . $usReplier->getUserName() . " " . '</a><span style="font-weight: bold;">replied </span>' . $periodReply .
                        '    
                                            <h5>' . $twReplier->getTweetText() . '</h5>
                                            <BR>
                                            <a href="LikeTweet.php?tweetId=' . $twReplier->getTweetId() . '">
                                            <img class="bannericons" src="Images/' . $likeIcon . '">
                                            </a>
                                            ' . $likesCount . '
                                            <a href="Retweet.php?tweetId=' . $twReplier->getTweetId() . '">
                                            <img class="bannericons" src="Images/retweet.png">
                                            </a>
                                            <a href="Reply.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/reply.png">
                                            </a>
                                            </div>
                                            ';
                    }
                }
                echo
                '
                                            <hr>
                                            </div>';
            }
        }
    }

//Displaying Tweets Method end
//Validate phone method
    private static function fnValidPhone($str) { //Adapted from: https://www.reddit.com/r/PHP/comments/18j6k9/heres_a_function_to_reliably_validate_and_format/
        $str = trim($str);
        $str = preg_replace('/\s+(#|x|ext(ension)?)\.?:?\s*(\d+)/', ' ext \3', $str);

        $ca_number = preg_match('/^(\+\s*)?((0{0,2}1{1,3}[^\d]+)?\(?\s*([2-9][0-9]{2})\s*[^\d]?\s*([2-9][0-9]{2})\s*[^\d]?\s*([\d]{4})){1}(\s*([[:alpha:]#][^\d]*\d.*))?$/', $str, $matches);

        if ($ca_number) {
            return $matches[4] . '-' . $matches[5] . '-' . $matches[6] . (!empty($matches[8]) ? ' ' . $matches[8] : '' );
        }

        $valid_number = preg_match('/^(\+\s*)?(?=([.,\s()-]*\d){8})([\d(][\d.,\s()-]*)([[:alpha:]#][^\d]*\d.*)?$/', $str, $matches) && preg_match('/\d{2}/', $str);

        if ($valid_number) {
            return trim($matches[1]) . trim($matches[3]) . (!empty($matches[4]) ? ' ' . $matches[4] : '' );
        }

        /* SET ERROR: The field must be a valid phone number (e.g. 888-888-8888) */
        return false;
    }

//Validate postal canadian postal code
    private static function fnValidatePostalFormat($postalCode) { //Adapted from https://gist.github.com/james2doyle/c310e6ceeb3bad437621
        $expression = '/^([a-zA-Z]\d[a-zA-Z])\ {1}(\d[a-zA-Z]\d)$/';
        if ((bool) preg_match($expression, $postalCode)) { //Got it on https://snipplr.com/view/16911/validate-canadian-postal-code/
            return true;
        } else {
            return false;
        }
    }

    private static function fnValidatePostal($postalCode, $sRegion) {
        $url = "http://localhost/includes/Fedex/ValidatePostalCodeService/ValidatePostalCodeWebServiceClient.php";
        $cobj = curl_init();
        curl_setopt($cobj, CURLOPT_URL, $url);
        curl_setopt($cobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cobj, CURLOPT_HEADER, 0);
        curl_setopt($cobj, CURLOPT_POSTFIELDS,
                "PostalCode=" . $postalCode);
        $output = curl_exec($cobj);
        if ($output === FALSE) {
            echo "ERROR";
        }
        curl_close($cobj);
        print_r($output);
    }

    static function signUp($con, $confirm, $firstname, $lastname, $email, $username, $password, $phone, $address, $province, $postalCode, $url, $desc, $location) {
        $user = new User();
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
        $user->setEmail($email);
        $user->setUserName($username);
        $user->setPassword($password);
        $user->setContactNo($phone);
        $user->setAddress($address);
        $user->setProvince($province);
        $user->setPostalCode($postalCode);
        $user->setUrl($url);
        $user->setDescription($desc);
        $user->setLocation($location); //not required
        $table = "users";
        if (strlen($user->getFirstName()) > 50 || strlen($user->getLastName()) > 50 || strlen($user->getUserName()) > 50 || strlen($user->getPassword()) > 250 || strlen($user->getAddress()) > 200 || strlen($user->getProvince()) > 50 || strlen($user->getPostalCode()) > 7 || strlen($user->getContactNo()) > 25 || strlen($user->getEmail()) > 100 || strlen($user->getUrl()) > 50 || strlen($user->getDescription()) > 160 || strlen($user->getLocation()) > 50) {
            $msg = "There is too many characters in one or more fields. Please try again.";
        } else {
//Checking if the username is already being used
            $user->setUserName(strtolower($user->getUserName()));

            $userNameStatement = "SELECT `user_id` FROM `users` WHERE `screen_name` = '" . $user->getUserName() . "'";
            $recordSet = mysqli_query($con, $userNameStatement)
                    or die($userNameStatement . " : " . mysqli_connect_error()); //Executes query
            if (mysqli_num_rows($recordSet) != 0) {
                $msg = "This user name is already being used. Please choose another one.";
            } else {
                if ($user->getPassword() === $confirm) {
                    $newPhone = preg_replace("/[^0-9]/", "", $user->getContactNo());
                    if (User::fnValidPhone($user->getContactNo())) {
                        $areaCode = substr($newPhone, 0, 3);
                        $firstPhonePart = substr($newPhone, 3, 3);
                        $secondPhonePart = substr($newPhone, 6);
                        $user->setContactNo('(' . $areaCode . ')' . ' ' . $firstPhonePart . ' ' . $secondPhonePart);
//Validating email and url - //https://www.w3schools.com/php/php_form_url_email.asp
                        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
                            $msg = "Invalid email format.";
                        } else {
                            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $user->getUrl())) {
                                $msg = "Invalid URL address.";
                            } else {
                                $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT)); //Encrypting password
                                $user->setPostalCode(strtoupper($user->getPostalCode())); //Postal Code uppercased pattern
//Insert into table  
                                $sql = "INSERT INTO `users` (`first_name`, `last_name`, `screen_name`, `password`, `address`, `province`, `postal_code`, `contact_number`, `email`, `url`, `description`, `location`, `date_created`, `profile_pic`) "
                                        . "VALUES ('" . $user->getFirstName() . "', '" . $user->getLastName() . "', '" . $user->getUserName() . "', '" . $user->getPassword() . "',"
                                        . " '" . $user->getAddress() . "', '" . $user->getProvince() . "', '" . $user->getPostalCode() . "', '" . $user->getContactNo() . "', "
                                        . "'" . $user->getEmail() . "', '" . $user->getUrl() . "', '" . $user->getDescription() . "', '" . $user->getLocation() . "', CURRENT_TIMESTAMP, 'default.jfif')";

                                mysqli_query($con, $sql)
                                        or die($sql . " : " . mysqli_connect_error());
                                if (mysqli_affected_rows($con) == 1) {
                                    $msg = "Your registration was successful!";
                                } else {
                                    $msg = "Error on your registration. Please try again.";
                                }
                            }
                        }
                    }//End if-insert
                    else {
                        $msg = "Please enter a valid phone number.";
                    }
                } else {
                    $msg = "Password and confirmation password do not match.";
                }//end password confirmation
            }
        }
        Header("location:signup.php?msg=$msg");
    }

    static function userPageDisplayTweets($userId, $con) {//Displaying only TWEETS and RETWEETS (not replies)
//        $tweetsCounter = 10; //Limit amount of tweets being displayed
        $defaultReplyToTweetId = 0; //Default to check if the tweet is a reply or not
        $sqlTweet = "SELECT DISTINCT users.first_name, users.last_name, users.screen_name, users.user_id, "
                . "tweets.tweet_text, tweets.tweet_id, tweets.reply_to_tweet_id, tweets.original_tweet_id, tweets.date_created, tweets.user_id "
                . "FROM users users "
                . "INNER JOIN tweets tweets ON users.user_id = tweets.user_id "
                . "INNER JOIN follows follows ON tweets.user_id = follows.to_id "
                . "WHERE tweets.user_id = '" . $userId . "' "
                . "AND tweets.reply_to_tweet_id ='" . $defaultReplyToTweetId . "' "
                . "ORDER BY tweets.date_created DESC ";
//                . "LIMIT $tweetsCounter";
        $tweetsRS = mysqli_query($con, $sqlTweet)
                or die($sqlTweet . " : " . mysqli_error($con));
        while ($tweets = mysqli_fetch_array($tweetsRS)) {
//Creating Objects and setting attributes
            $twUser = new User();
            $twTweet = new Tweet();
            $twTweet->setTweetText($tweets['tweet_text']); //Tweet
            $twTweet->setTweetId($tweets['tweet_id']); //Tweet
            $twTweet->setDateAdded($tweets['date_created']); //Tweet
            $twTweet->setOriginalTweetId($tweets['original_tweet_id']); //Tweet
            $twTweet->setReplytoTweetId($tweets['reply_to_tweet_id']);
            $twUser->setFirstName($tweets['first_name']); //User
            $twUser->setLastName($tweets['last_name']); //User
            $twUser->setUserName($tweets['screen_name']); //User
            $twUser->setUserId($tweets['user_id']); //User
//Getting the tweeted period
            $now = new DateTime();
            $tweetTime = new DateTime($twTweet->getDateAdded());
            $interval = $tweetTime->diff($now);
            if ($interval->y > 1)
                $period = $interval->format('%y years') . " ago";
            elseif ($interval->y > 0)
                $period = $interval->format('%y year') . " ago";
            elseif ($interval->m > 1)
                $period = $interval->format('%m months') . " ago";
            elseif ($interval->m > 0)
                $period = $interval->format('%m month') . " ago";
            elseif ($interval->d > 1)
                $period = $interval->format('%d days') . " ago";
            elseif ($interval->d > 0)
                $period = $interval->format('%d day') . " ago";
            elseif ($interval->h > 1)
                $period = $interval->format('%h hours') . " ago";
            elseif ($interval->h > 0)
                $period = $interval->format('%h hour') . " ago";
            elseif ($interval->i > 1)
                $period = $interval->format('%i minutes') . " ago";
            elseif ($interval->i > 0)
                $period = $interval->format('%i minute') . " ago";
            elseif ($interval->s > 1)
                $period = $interval->format('%s seconds') . " ago";
            elseif ($interval->s > 0)
                $period = $interval->format('%s second') . " ago";
            else
                $period = "just now";
//Creating/Displaying tweets
            if ($twTweet->getOriginalTweetId() != 0) {//Checks if it's a retweet
                $rtUser = new User();
                $sqlSt = "SELECT u.user_id, u.first_name, u.last_name "
                        . "FROM users u INNER JOIN tweets t ON t.user_id = u.user_id "
                        . "WHERE t.tweet_id = '" . $twTweet->getOriginalTweetId() . "' "
                        . "AND t.reply_to_tweet_id ='" . $defaultReplyToTweetId . "'";
                $resultSet = mysqli_query($con, $sqlSt)
                        or die($sqlSt . " : " . mysqli_error($con)); //Executes query
                $result = mysqli_fetch_array($resultSet);
                $rtUser->setFirstName($result['first_name']);
                $rtUser->setLastName($result['last_name']);
//
//selection like icon
//
                if ($twTweet->likedTweet($con, $twTweet->getTweetId(), $_SESSION['SESS_MEMBER_ID']) == 1) {
                    $likeIcon = "like.png";
                } else {
                    $likeIcon = "liked.png";
                }

//
//Counting likes
//
                $likesCount = Tweet::countLikes($con, $twTweet->getTweetId());
                echo
                '
                                        <div class="container">
                                            <a href="userpage.php?user_id=' . $twUser->getUserId() . '">' .
                $twUser->getFirstName() . " " . $twUser->getLastName() . " @" . $twUser->getUserName() . " " . '</a>' . $period .
                ' <span style="font-weight: bold;">retweeted from ' . $rtUser->getFirstName() . ' ' . $rtUser->getLastName() . ' </span>   
                                            <h5>' . $twTweet->getTweetText() . '</h5>
                                            <BR>
                                            <a href="LikeTweet.php?tweet_Id=' . $twTweet->getTweetId() . '&user_id=' . $twUser->getUserId() . '">
                                            <img class="bannericons" src="Images/' . $likeIcon . '">
                                            </a>
                                            ' . $likesCount . '
                                            <a href="Retweet.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/retweet.png">
                                            </a>
                                            <a href="Reply.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/reply.png">
                                            </a>
                                            ';
                echo
                '
                                            <hr>
                                            </div>';
            } else {
                if ($twTweet->likedTweet($con, $twTweet->getTweetId(), $_SESSION['SESS_MEMBER_ID']) == 1) {
                    $likeIcon = "like.png";
                } else {
                    $likeIcon = "liked.png";
                }
//
//Counting likes
//
                $likesCount = Tweet::countLikes($con, $twTweet->getTweetId());
                echo
                '
                                        <div class="container">
                                            <a href="userpage.php?user_id=' . $twUser->getUserId() . '">' .
                $twUser->getFirstName() . " " . $twUser->getLastName() . " @" . $twUser->getUserName() . " " . '</a>' . $period . '    
                                            <h5>' . $twTweet->getTweetText() . '</h5>
                                            <BR>
                                            <a href="LikeTweet.php?tweet_Id=' . $twTweet->getTweetId() . '&user_id=' . $twUser->getUserId() . '">
                                            <img class="bannericons" src="Images/' . $likeIcon . '">
                                            </a>
                                            ' . $likesCount . '
                                            <a href="Retweet.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/retweet.png">
                                            </a>
                                            <a href="Reply.php?tweetId=' . $twTweet->getTweetId() . '">
                                            <img class="bannericons" src="Images/reply.png">
                                            </a>
                                             <hr>
                                            </div>';
            }
        }
    }

    static function convertProvince($userProvince) {
        switch ($userProvince) {
            case ("New Brunswick"):
                $region = 'nb';
                break;
            case ("Newfoundland and Labrador"):
                $region = 'nl';
                break;
            case ("Newfoundland and Labrador"):
                $region = 'nl';
                break;
            case ("Newfoundland and Labrador"):
                $region = 'nl';
                break;
            case ("British Columbia"):
                $region = 'bc';
                break;
            case ("Alberta"):
                $region = 'ab';
                break;
            case ("Saskatchewan"):
                $region = 'sk';
                break;
            case ("Manitoba"):
                $region = 'mb';
                break;
            case ("Ontario"):
                $region = 'on';
                break;
            case ("Quebec"):
                $region = 'qc';
                break;
            case ("Prince Edward Island"):
                $region = 'pe';
                break;
            case ("Nova Scotia"):
                $region = 'ns';
                break;
            case ("Northwest Territories"):
                $region = 'nt';
                break;
            case ("Nunavut"):
                $region = 'nu';
                break;
            case ("Yukon"):
                $region = 'yt';
                break;
        }
        return $region;
    }

    static function notificationsPageDisplayInfo($userId, $con) {//Likes, retweets and replies
        $mainUser = new User();
        $mainUser = $mainUser->setAll($userId, $con);
        $likes = "SELECT l.like_id, t.tweet_text, t.original_tweet_id, t.reply_to_tweet_id, l.user_id, l.date_created FROM tweets t INNER JOIN likes l ON l.tweet_id = t.tweet_id WHERE t.user_id=" . $mainUser->getUserId();
        $retweets = "SELECT t1.tweet_id, t1.tweet_text, t1.original_tweet_id,t1.reply_to_tweet_id, t1.user_id, t1.date_created FROM tweets t1 INNER JOIN tweets t2 ON t2.original_tweet_id = t1.tweet_id WHERE t2.original_tweet_id!=0 AND t1.user_id !=" . $mainUser->getUserId();
        $replies = "SELECT t3.tweet_id, t3.tweet_text, t3.original_tweet_id,t3.reply_to_tweet_id, t3.user_id, t3.date_created FROM tweets t3 INNER JOIN tweets t4 ON t4.reply_to_tweet_id = t3.tweet_id WHERE t4.reply_to_tweet_id!=0 AND t3.user_id !=" . $mainUser->getUserId();
        //
        $sqlStatement = $likes . " UNION (" . $retweets . ") UNION (" . $replies . ") ORDER BY date_created DESC";
        //
        $rs = mysqli_query($con, $sqlStatement)
                or die($sqlStatement . " : " . mysqli_connect_error());
        while ($result = mysqli_fetch_array($rs)) {
            $userSec = new User();
            $userSec = $userSec->setAll($result['user_id'], $con);
            $tweet = new Tweet();
            $tweet->setTweetText($result['tweet_text']);
            $tweet->setDateAdded($result['date_created']);
            //Getting the tweeted period
            $now = new DateTime();
            $tweetTime = new DateTime($tweet->getDateAdded());
            $interval = $tweetTime->diff($now);
            if ($interval->y > 1)
                $period = $interval->format('%y years') . " ago";
            elseif ($interval->y > 0)
                $period = $interval->format('%y year') . " ago";
            elseif ($interval->m > 1)
                $period = $interval->format('%m months') . " ago";
            elseif ($interval->m > 0)
                $period = $interval->format('%m month') . " ago";
            elseif ($interval->d > 1)
                $period = $interval->format('%d days') . " ago";
            elseif ($interval->d > 0)
                $period = $interval->format('%d day') . " ago";
            elseif ($interval->h > 1)
                $period = $interval->format('%h hours') . " ago";
            elseif ($interval->h > 0)
                $period = $interval->format('%h hour') . " ago";
            elseif ($interval->i > 1)
                $period = $interval->format('%i minutes') . " ago";
            elseif ($interval->i > 0)
                $period = $interval->format('%i minute') . " ago";
            elseif ($interval->s > 1)
                $period = $interval->format('%s seconds') . " ago";
            elseif ($interval->s > 0)
                $period = $interval->format('%s second') . " ago";
            else
                $period = "just now";
            if (($result['original_tweet_id'] != 0) && ($userSec->getUserId() != $mainUser->getUserId())) {//RETWEETS
                echo
                '
            <div class="container">
                <img class="bannericons" src="/images/profilepics/' . $userSec->getProfImage() . '">
                <a href="userpage.php?user_id=' . $userSec->getUserId() . '">' .
                $userSec->getFirstName() . " " . $userSec->getLastName() . '</a> retweeted your tweet ' . $period .
                ' <span style="font-weight: bold;
"><BR>retweeted from ' . $mainUser->getFirstName() . ' ' . $mainUser->getLastName() . ' </span>'
                . '<BR><BR>'
                . '<h5>' . $tweet->getTweetText() . '</h5>
                <hr>
            </div>';
            } if (($result['reply_to_tweet_id'] != 0) && ($userSec->getUserId() != $mainUser->getUserId())) {//REPLIES
                echo
                '
            <div class="container">
                <img class="bannericons" src="/images/profilepics/' . $userSec->getProfImage() . '">
                <a href="userpage.php?user_id=' . $userSec->getUserId() . '">' .
                $userSec->getFirstName() . " " . $userSec->getLastName() . '</a> replied you  ' . $period
                . '<BR><BR>'
                . '<h5>' . $tweet->getTweetText() . '</h5>
                <hr>
            </div>';
            } if (($result['like_id'] != 0) && ($userSec->getUserId() != $mainUser->getUserId())) {//LIKES
                echo
                '
            <div class="container">
                <img class="bannericons" src="/images/profilepics/' . $userSec->getProfImage() . '">
                <a href="userpage.php?user_id=' . $userSec->getUserId() . '">' .
                $userSec->getFirstName() . " " . $userSec->getLastName() . '</a> liked your tweet ' . $period
                . '<BR><BR>'
                . '<h5>' . $tweet->getTweetText() . '</h5>
                <hr>
            </div>';
            }
        }
    }

    static function getAllMessages($con, $userId) {
        $toUser = new User();
        $toUser->setUserId($userId);
        $toUser = $toUser->setAll($toUser->getUserId(), $con);
        $sql = "SELECT from_id, to_id, message_text, date_sent FROM messages WHERE to_id = $userId";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        while ($result = mysqli_fetch_array($rs)) {
            $fromUser = new User();
            $fromUser->setUserId($result['from_id']);
            $fromUser = $fromUser->setAll($fromUser->getUserId(), $con);

            echo
            '
            <div class="container">
                <a href="userpage.php?user_id = ' . $fromUser->getUserId() . '">' .
            $fromUser->getFirstName() . " " . $fromUser->getLastName() . " @" . $fromUser->getUserName() . " " . '</a>    
                <h5>' . $result['message_text'] . '</h5>
                <BR>
                <hr>
            </div>';
        }
    }

    static function addMessage($mainUserId, $toUserId, $con) {
        $message_text = $_POST['message'];
        $sql = "INSERT INTO messages (from_id, to_id, message_text, date_sent) VALUES ($mainUserId, $toUserId, '" . $message_text . "', CURRENT_TIMESTAMP)";
        mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        if (mysqli_affected_rows($con) == 1) {
            $msg = "Your message was sent!";
        } else {
            $msg = "Sorry, your message was not sent... please try again.";
        }
        Header("location:DirectMessage.php?msg = $msg");
    }

    static function getUserByScreenName($screen_name, $con) {
        $sql = "SELECT * FROM users WHERE screen_name = '" . $screen_name . "'";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        $result = mysqli_fetch_array($rs);
        if (mysqli_num_rows($rs) <= 0) {
            return null;
        } else {
            $user = new User();
            $user = $user->setAll($result['user_id'], $con);
            return $user;
        }
    }

    static function getUsers($to, $con) {
        $sqlStatement = "SELECT * FROM users WHERE first_name LIKE '%" . $to . "%' OR last_name LIKE '%" . $to . "%' OR screen_name LIKE '%" . $to . "%'";
        $rs = mysqli_query($con, $sqlStatement)
                or die($sqlStatement . " : " . mysqli_connect_error());
        return $rs;
    }

}
