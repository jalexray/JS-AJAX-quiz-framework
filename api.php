<?php
/*
This is a php-based example of how to make an api that delivers one question at a time. This really isn't the most elegant way to do this, but maybe use this as a springboard for ways to make new ones.

In real life, if you were going to use this type of framework, you'll want to get the information in the "Question Choice Phase" of this document from a database. 

In the "Submission Processing Phase" section, we take the POST from the quiz.html AJAX request and process it. In real life, you'll put this information in a database. You'll probably want to record a few more stats with it, rather than just the Question ID and the Answer - for example, who answered it? And when?

In the "Question Choice Phase" section, we get 1) a list of questions (with ID and the question text) and 2) a list of questions the current user has already answered. We use these two arrays to create a new array of questions the current user has not answered. Then, we select a random question from the new array. We echo this as the response to the quiz.html AJAX request.

This isn't a very elegant way to do this, but in real life you'll be using a database, rather than a hardcoded PHP array.
*/

//PHASE I: Submission Processing Phase
$response = $_POST["response"];
$questionID = $_POST["questionID"];

// At this point, you'll store these in a database. Be sure to protect yourself!

// PHASE II: Question Choice Phase
// In reality, you'll populate this from a database. I input ten questions for this example.
$arrayAllQuestions = array("1"=>"Do you like cats?","2"=>"Do you like programming?","3"=>"Do you like dogs?","4"=>"Do you like pancakes?","5"=>"Do you like the color green?","6"=>"Do you like this website?","7"=>"Do you like open source material?","8"=>"Would you jump off a bridge if your friends did it?","9"=>"Do you like to play video games?","10"=>"Do you like coffee?",);

// In reality, you'll populate this from a database. I input a few questions that our user has already answered based on the fibonacci sequence. We'll also add whatever question was just answered to this, so that my example doesn't ever ask the same question twice. 
$arrayAnsweredQuestions = array("1"=>"Do you like cats?","2"=>"Do you like programming?","3"=>"Do you like dogs?","5"=>"Do you like the color green?","8"=>"Would you jump off a bridge if your friends did it?");

// This is a pretty clunky way to do this.
$questionAnsweredLastTime = $arrayAllQuestions[$questionID];
$arrayAnsweredQuestions[] = $questionAnsweredLastTime;

// Now we compare those two arrays to make a new array, with only unanswered questions in it.
$derivedArrayUnansweredQuestions = array_diff($arrayAllQuestions, $arrayAnsweredQuestions);

// Now we'll pick a random one from there (Note: array_rand uses the libc generator, which is slower and less-random than Mersenne Twister) and return it using print_r. The AJAX function will return whatever question and questionID
$randomUnansweredQuestion = array_rand($derivedArrayUnansweredQuestions,1);
$result["newQuestionText"] = $derivedArrayUnansweredQuestions[$randomUnansweredQuestion];
$result["newQuestionID"] = $randomUnansweredQuestion;

echo json_encode($result);



?>