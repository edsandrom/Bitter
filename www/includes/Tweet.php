<?php

/**
 * Description of Tweet
 *
 * @author Edsandro de Oliveira <edsandrom@gmail.com>
 */
class Tweet {

    //Integer
    private $tweetId, $userId, $originalTweetId, $replytoTweetId;
    //String
    private $tweetText, $dateAdded;

    //Constructor
    function __construct() {
//        $this->tweetId = $tweetId;
//        $this->userId = $userId;
//        $this->originalTweetId = $originalTweetId;
//        $this->replytoTweetId = $replytoTweetId;
//        $this->tweetText = $tweetText;
//        $this->dateAdded = $dateAdded;
    }

    //Destructor
    public function __destruct() {
        //Doing nothing
    }

    //Geters and Setters
    function getTweetId() {
        return $this->tweetId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getOriginalTweetId() {
        return $this->originalTweetId;
    }

    function getReplytoTweetId() {
        return $this->replytoTweetId;
    }

    function getTweetText() {
        return $this->tweetText;
    }

    function getDateAdded() {
        return $this->dateAdded;
    }

    function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setOriginalTweetId($originalTweetId) {
        $this->originalTweetId = $originalTweetId;
    }

    function setReplytoTweetId($replytoTweetId) {
        $this->replytoTweetId = $replytoTweetId;
    }

    function setTweetText($tweetText) {
        $this->tweetText = $tweetText;
    }

    function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }
    
    static function countLikes($con, $tweetId){
        $sql = "SELECT like_id FROM likes WHERE tweet_id = $tweetId";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        $count = mysqli_affected_rows($con);
        if ($count == 0){
            return null;
        }
        else return $count;  
    }

    function likedTweet($con, $tweetId, $userId) {
        $sql = "SELECT like_id FROM likes l INNER JOIN tweets t ON l.tweet_id = t.tweet_id "
                . "WHERE (l.user_id =" . $userId . " AND l.tweet_id =" . $tweetId.")";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        if (mysqli_fetch_array($rs) == 0) {
            $liked = 1;
        } else {
            $liked = 0;
        }
        return $liked;
    }

    function insertLike($con, $tweetId, $userId) {
        $insert = "INSERT INTO likes (tweet_id, user_id, date_created) "
                . "VALUES ('" . $tweetId . "', " . $userId . ", CURRENT_TIMESTAMP)";
        mysqli_query($con, $insert)
                or die($insert . " : " . mysqli_connect_error());
    }

    function removeLike($con, $tweetId, $userId) {
        $remove = "DELETE FROM likes WHERE tweet_id = $tweetId AND user_Id = $userId";
        mysqli_query($con, $remove)
                or die($remove . " : " . mysqli_connect_error());
    }

    static function searchTweets($word, $con) {
        $sql = "SELECT tweet_id, tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created FROM tweets WHERE tweet_text LIKE '%" . $word . "%'";
        $rs = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        return $rs;
    }

    static function replyTweet($tweetId, $replyUserId, $replyTweetText, $replyToTweetId, $con) {
        $sqlStatement = "SELECT user_id "
                . "FROM Tweets WHERE tweet_id ='" . $tweetId . "'";
        $recordSet = mysqli_query($con, $sqlStatement)
                or die($sqlStatement . " : " . mysqli_error($con)); //Executes query
        $result = mysqli_fetch_array($recordSet);
        $sql = "INSERT INTO tweets (user_id, tweet_text, reply_to_tweet_id, date_created) "
                . "VALUES ('" . $replyUserId . "', '" . $replyTweetText . "', '" . $replyToTweetId . "', CURRENT_TIMESTAMP)";
        $recordSet = mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        if (mysqli_affected_rows($con) == 1) {
            $msg = "Replied!";
        } else {
            $msg = "Error on replying. Please try again.";
        }
        header("location:index.php?msg=$msg");
    }

    static function retweet($tweetId, $newUserId, $con) {
        $sqlStatement = "SELECT `user_id`, tweet_id, tweet_text, original_tweet_id, reply_to_tweet_id "
                . "FROM Tweets WHERE tweet_id ='" . $tweetId . "'";
        $recordSet = mysqli_query($con, $sqlStatement)
                or die($sqlStatement . " : " . mysqli_error($con)); //Executes query
        $result = mysqli_fetch_array($recordSet);
        $retweetText = addslashes($result['tweet_text']);
        $retweetUserId = $newUserId;
        $retweetOriginalTweetId = $result['tweet_id'];
        $sql = "INSERT INTO `tweets` (`tweet_text`, `user_id`, original_tweet_id, `date_created`) "
                . "VALUES ('" . $retweetText . "', " . $retweetUserId . ", " . $retweetOriginalTweetId . ", CURRENT_TIMESTAMP)";
        mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        if (mysqli_affected_rows($con) == 1) {
            $msg = "Retweeted!";
        } else {
            $msg = "Error on retweeting. Please try again.";
        }
        header("location:index.php?msg=$msg");
    }

    static function tweet($tweetText, $userId, $con) {
        //Insert into table  
        $sql = "INSERT INTO `tweets` (`tweet_text`, `user_id`, `date_created`) "
                . "VALUES ('" . $tweetText . "', '" . $userId . "', CURRENT_TIMESTAMP)";
        mysqli_query($con, $sql)
                or die($sql . " : " . mysqli_connect_error());
        if (mysqli_affected_rows($con) == 1) {
            $msg = "Tweeted!";
        } else {
            $msg = "Error on Tweeting. Please try again.";
        }
        header("location:index.php?msg=$msg");
    }

    static function tweetSearchDisplayTweets($tweetId, $con) {//Displaying only TWEETS and RETWEETS (not replies)
//        $tweetsCounter = 10; //Limit amount of tweets being displayed
        $defaultReplyToTweetId = 0; //Default to check if the tweet is a reply or not
        $sqlTweet = "SELECT DISTINCT users.first_name, users.last_name, users.screen_name, users.user_id, "
                . "tweets.tweet_text, tweets.tweet_id, tweets.reply_to_tweet_id, tweets.original_tweet_id, tweets.date_created, tweets.user_id "
                . "FROM users users "
                . "INNER JOIN tweets tweets ON users.user_id = tweets.user_id "
                . "INNER JOIN follows follows ON tweets.user_id = follows.to_id "
                . "WHERE tweets.tweet_id = '" . $tweetId . "' "
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
                echo
                '
                                        <div class="container">
                                            <a href="userpage.php?user_id=' . $twUser->getUserId() . '">' .
                $twUser->getFirstName() . " " . $twUser->getLastName() . " @" . $twUser->getUserName() . " " . '</a>' . $period .
                ' <span style="font-weight: bold;">retweeted from ' . $rtUser->getFirstName() . ' ' . $rtUser->getLastName() . ' </span>   
                                            <h5>' . $twTweet->getTweetText() . '</h5>
                                            <BR>
                                            <img class="bannericons" src="Images/like.ico">
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
                echo
                '
                                        <div class="container">
                                            <a href="userpage.php?user_id=' . $twUser->getUserId() . '">' .
                $twUser->getFirstName() . " " . $twUser->getLastName() . " @" . $twUser->getUserName() . " " . '</a>' . $period . '    
                                            <h5>' . $twTweet->getTweetText() . '</h5>
                                            <BR>
                                            <img class="bannericons" src="Images/like.ico">
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

}
