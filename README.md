CSMVoteMatch
============

A Vote Match website for the Eve Online Council of Stellar Management elections.

#How matching is done

The matching algorithm works by calculating a fidelity score for each answer of a candidate and making a total of all the scores. The fidelity score of a question is a product of three variables: the answer score, the importance score and the weight.

##The answer score
Statements can be answered in 5 ways: Strongly disagree, Disagree, No opinion, Agree and Strongly agree. Depending on the answer of the user and the answer of the candidate, the answer score will be one of the following: Strong positive match (2), Weak positive match (1), Neutral match (0), Weak negative match (-1), Strong negative match (-2). These values are assigned as follows (user answrs on X axis, candidate answers on Y axis):

<table>
  <tr>
    <th>Answer</th>
    <th>Strongly disagree</th>
    <th>Disagree</th>
    <th>No opinion</th>
    <th>Agree</th>
    <th>Strongly agree</th>
  </tr>
  <tr>
    <th>Strongly disagree</th>
    <td>Strong positive match</td>
    <td>Weak positive match</td>
    <td>Neutral match</td>
    <td>Strong negative match</td>
    <td>Strong negative match</td>
  </tr>
  <tr>
    <th>Disagree</th>
    <td>Weak positive match</td>
    <td>Strong positive match</td>
    <td>Neutral match</td>
    <td>Weak negative match</td>
    <td>Strong negative match</td>
  </tr>
  <tr>
    <th>No opinion</th>
    <td>Weak negative match</td>
    <td>Weak negative match</td>
    <td>Neutral match</td>
    <td>Weak negative match</td>
    <td>Weak negative match</td>
  </tr>
  <tr>
    <th>Agree</th>
    <td>Strong negative match</td>
    <td>Weak negative match</td>
    <td>Neutral match</td>
    <td>Strong positive match</td>
    <td>Weak positive match</td>
  </tr>
  <tr>
    <th>Strongly agree</th>
    <td>Strong negative match</td>
    <td>Strong negative match</td>
    <td>Neutral match</td>
    <td>Weak positive match</td>
    <td>Strong positive match</td>
  </tr>
</table>

## Importance score
It is important to keep in mind that we're trying to calculate how well person A matches with person B, and their fidelity score should reflect the interpersonal match rather than the importance of the specific statement. That is why we use the weight assigned by both the user and candidate as a second matching dimension. 

The weight score is used to modified the answer score, and either doubles or halves the answer score. The weight score is decided as follows:

<table>
  <tr>
    <th></th>
    <th>Agree on statement</th>
    <th>Disagree on statement</th>
  </tr>
  <tr>
    <th>Agree important</th>
    <td>increase positive match</td>
    <td>increase negative match</td>
  </tr>
  <tr>
    <th>Agree not important</th>
    <td>increase positive match</td>
    <td>decrease negative match</td>
  </tr>
  <tr>
    <th>Disagree importance</th>
    <td>decrease positive match</td>
    <td>decrease negative match</td>
  </tr>
</table>

Keep in mind that a negative match score will never flip to positive match score and vice versa due to importance scores, it will only trend more or less towards 0. As such, in the above table "decrease" means "decrease towards 0" and "increase" means "increase away from 0".

## Weight

The last factor in the fidelity score is the weight assigned to the answer by the user. This means that questions the user has rated as more important (importance score higher than 1) will have more impact on his overall match with a candidate than questions he has market as being less important (less than 1).

## Putting it all together

Fidelity is then calculated like so: `(answer_score * importance_score) * weight`.

## Some examples to illustrate
Imagine the following statement:
> All level 4 missions in high sec should be moved to lowsec

<table>
  <tr>
    <th>Case 1</th>
  </tr>
  <tr>
    <th>Person</th>
    <th>Answer</th>
    <th>Weight</th>
  </tr>
  <tr>
    <th>User</th>
    <td>Strongly disagree</td>
    <td>1.5</td>
  </tr>
  <tr>
    <th>Candidate</th>
    <td>Strongly disagree</td>
    <td>1.0</td>
  </tr>
</table>

Both people have the same answer, and both agree that the question is not unimportant. As such, they have a 2 point answer match (strong positive match), with a 2 point importance multiplier. These four points will then be multiplied by the user's weight of 1.5 for a total 6 point fidelity score.

<table>
  <tr>
    <th>Case 2</th>
  </tr>
  <tr>
    <th>Person</th>
    <th>Answer</th>
    <th>Weight</th>
  </tr>
  <tr>
    <th>User</th>
    <td>Strongly disagree</td>
    <td>1.5</td>
  </tr>
  <tr>
    <th>Candidate</th>
    <td>Disagree</td>
    <td>0.5</td>
  </tr>
</table>

Both people have similar answers, but the small difference (Strongly disagree vs disagree) indicates a small difference in opinion. This only results in a 1 point answer match (weak positive match). They differ in opinion on importance however, with the user feeling this is an important issue and the candidate feeling it is significantly less important. This results in a decrease of the weak positive match with the importance multiplier of 0.5. The resulting score of 0.5 is then multiplied by the user's 1.5 weight for a total fidelity score of 0.75.

<table>
  <tr>
    <th>Case 3</th>
  </tr>
  <tr>
    <th>Person</th>
    <th>Answer</th>
    <th>Weight</th>
  </tr>
  <tr>
    <th>User</th>
    <td>Disagree</td>
    <td>1.5</td>
  </tr>
  <tr>
    <th>Candidate</th>
    <td>Agree</td>
    <td>1.3</td>
  </tr>
</table>

The user and the candidate have significantly different answers this time, resulting in a weak negative match of -1. Their difference in opinion is even greater when you see that they both feel this is an important issue (with opposing views), resulting in an importance multiplier of 2. The resulting -2 score is then multiplied by 1.5 for a total -3 fidelity score on this statement.

<table>
  <tr>
    <th>Case 4</th>
  </tr>
  <tr>
    <th>Person</th>
    <th>Answer</th>
    <th>Weight</th>
  </tr>
  <tr>
    <th>User</th>
    <td>Disagree</td>
    <td>1.5</td>
  </tr>
  <tr>
    <th>Candidate</th>
    <td>Agree</td>
    <td>0.3</td>
  </tr>
</table>

The user and the candidate have opposing views, again resulting in a weak negative match of -1. However, while this is an important issue to the user, it is significantly less so for the candidate. As a result the importance modifier is 0.5, resulting in a combined score -0.5. This is then multiplied by the user's 1.5 points for a fidelity score of -0.75. 

Note that In the fourth case, the negative match is made less severe by the difference in opinion on weight rather than more servere.
