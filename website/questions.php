<?php 


$stmt = $mysqli->prepare("SELECT * FROM questions AS q LEFT JOIN election_questions AS e ON e.questionid = q.id WHERE e.electionid = ? ORDER BY q.id ASC");
$stmt->bind_param("i", Config::active_election);
$stmt->execute();

$results = $stmt->get_result();

// print start of our javascript array:
echo 'var questions = [';

// print database result rows as javascript array elements
while($row = $result->fetch_assoc()){
	echo '["question1_en", "question1_ger", "question1_rus", "question1_jp"],';
}

// print end of the javascript array
echo '];';

$stmt->close();

?>