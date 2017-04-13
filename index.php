<?php
$num_skills=0;
$num_jobs=0;
$keys = 'category';
$rsss=array(
	"http://stackoverflow.com/jobs/feed?".$_SERVER['QUERY_STRING']
);
$skills = array();
$jobs = array();
foreach($rsss as $rss){
//	echo $rss;
//	echo "<br />";
	$file =  simplexml_load_string(file_get_contents($rss));
    foreach ($file->channel->item as $i => $item) {
        if(!empty($item)){
            foreach ($item->category as $c => $category) {
                $category = (string)$category;
                if(!empty($skills[$category])){
                    $skills[$category] = $skills[$category]+1;
                } else {
                    $skills[$category] = 1;
                }
                $num_skills++;
            }
            $num_jobs++;
        }
    }
    foreach ($file->channel->item as $i => $item) {
        if(!empty($item)){
            $job = array(
                'title'   => (string)$item->title,
                'link'   => (string)$item->link,
                'weight' => 0
            );
            foreach ($item->category as $c => $category) {
                $category = (string)$category;
                if(!empty($skills[$category])){
                    $job['weight'] = $job['weight'] + $skills[$category];
                }
            }
            $jobs[] = $job;
        }
    }

}

function cmp($a, $b) {
    return $b['weight'] - $a['weight'];
}

usort($jobs,"cmp");

function getRandomWeightedElement(array $weightedValues, $num_skills=NULL) {
	if($num_skills==NULL){
		$num_skills=(int) array_sum($weightedValues);
	}else{
	}
	$rand = mt_rand(1, $num_skills);

	foreach ($weightedValues as $key => $value) {
		$rand -= $value;
		if ($rand <= 0) {
			return $key;
		}
	}
}
arsort($skills, SORT_NUMERIC);

function printJobs(){
    global $jobs;
    global $num_jobs;
    echo "[{( " . $num_jobs . " )}]\n";
    foreach($jobs as $j => $job){
        ?>
        <li>[<?php echo str_pad($job['weight'], 4, "0", STR_PAD_LEFT); ?>] <a href="<?php echo $job['link']; ?>" target="_blank"><?php echo $job['title']; ?></a></li>
        <?php
    }
}
function printSkills(){
    global $skills;
    global $num_skills;
    echo "[{( " . $num_skills . " )}]\n";
    foreach($skills as $skill => $weight){
        ?>
        <li><a href="./?tl=<?php echo urlencode($skill); ?>"><?php echo "[".$skill."] => ".$weight; ?></a></li>
        <?php
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Career</title>
<style>
ul{
	padding: 5px 5px;
}
</style>
</head>

<body>
	<ul>
    	<li>
        	<a href="./">All</a>
            <ul>
                <li><a href="./?j=permanent">Permanent</a></li>
                <li><a href="./?j=contract">Contract</a></li>
            </ul>
            <ul>
                <li><a href="./?r=True">Allows Remote</a></li>
                <li><a href="./?t=True">Offers Relocation</a></li>
                <li><a href="./?v=True">Offers Visa Sponsorship</a></li>
                <li><a href="./?e=True">Offers Equity</a></li>
            </ul>
            <ul>
                <li><a href="./?l=Bangladesh&d=100">Bangladesh</a></li>
                <li><a href="./?l=Thailand&d=100">Thailand</a></li>
                <li><a href="./?l=Malaysia&d=100">Malaysia</a></li>
                <li><a href="./?l=Singapore&d=100">Singapore</a></li>
                <li><a href="./?l=Indonesia&d=100">Indonesia</a></li>
            </ul>
            <ul>
                <li><a href="./?ms=Student&mxs=Student">&gt;Student</a></li>
                <li><a href="./?ms=Student&mxs=Junior">&gt;Junior</a></li>
                <li><a href="./?ms=Student&mxs=MidLevel">&gt;MidLevel</a></li>
                <li><a href="./?ms=Student&mxs=Senior">&gt;Senior</a></li>
                <li><a href="./?ms=Student&mxs=Lead">&gt;Lead</a></li>
                <li><a href="./?ms=Student&mxs=Manager">&gt;Manager</a></li>
            </ul>
            <ul>
                <li><a href="./?ms=Student&mxs=Manager">Student&gt;</a></li>
                <li><a href="./?ms=Junior&mxs=Manager">Junior&gt;</a></li>
                <li><a href="./?ms=MidLevel&mxs=Manager">MidLevel&gt;</a></li>
                <li><a href="./?ms=Senior&mxs=Manager">Senior&gt;</a></li>
                <li><a href="./?ms=Lead&mxs=Manager">Lead&gt;</a></li>
                <li><a href="./?ms=Manager&mxs=Manager">Manager&gt;</a></li>
            </ul>
        </li>
    </ul>

<?php
$picked1=getRandomWeightedElement($skills, $num_skills);
echo "({[ " . $picked1 . ":" . $skills[$picked1] . " ]})\n";
echo "<br />";
//print_r($skills);
echo "<br />";
if(count($jobs)>count($skills)){
    printSkills();
    printJobs();
}else{
    printJobs();
    printSkills();
}
?>
</body>
</html>
