<?php
$num_skills = 0;
$num_jobs = 0;
$keys = 'category';
$rsss = array(
    "http://stackoverflow.com/jobs/feed?" . $_SERVER['QUERY_STRING']
);
$skills = array();
$jobs = array();
$thesaurus = array();
foreach ($rsss as $rss) {
//	echo $rss;
//	echo "<br />";
    $file = simplexml_load_string(file_get_contents($rss));
    foreach ($file->channel->item as $i => $item) {
        if (!empty($item)) {
            foreach ($item->category as $c => $category) {
                $category = setUniqueName((string)$category);
                if (!empty($skills[$category])) {
                    $skills[$category] = $skills[$category] + 1;
                } else {
                    $skills[$category] = 1;
                }
                $num_skills++;
            }
            $num_jobs++;
        }
    }
    foreach ($file->channel->item as $i => $item) {
        if (!empty($item)) {
            $job = array(
                'title' => (string)$item->title,
                'link' => (string)$item->link,
                'weight' => 0
            );
            foreach ($item->category as $c => $category) {
                $category = getUniqueName((string)$category);
                if (!empty($skills[$category])) {
                    $job['weight'] = $job['weight'] + $skills[$category];
                }
            }
            $jobs[] = $job;
        }
    }

}

function setUniqueName($subject)
{
    global $thesaurus;
    $synonym = getUniqueName($subject);
    if (array_key_exists($synonym, $thesaurus)) {
        if (array_key_exists($subject, $thesaurus[$synonym])) {
            $thesaurus[$synonym][$subject] = $thesaurus[$synonym][$subject] + 1;
        } else {
            $thesaurus[$synonym][$subject] = 1;
        }
    } else {
        $thesaurus[$synonym][$subject] = 1;
    }
    return $synonym;
}

function getUniqueName($subject)
{
    return preg_replace("/\d+$/", "", str_replace(['js', '-', '.'], "", $subject));
}

function cmp($a, $b)
{
    return $b['weight'] - $a['weight'];
}

usort($jobs, "cmp");

function getRandomWeightedElement(array $weightedValues, $num_skills = NULL)
{
    if ($num_skills == NULL) {
        $num_skills = (int)array_sum($weightedValues);
    } else {
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

function printSynonyms()
{
    global $thesaurus;
    foreach ($thesaurus as $skill => $synonyms) {
        if (count($synonyms) > 1) {
            echo '<pre>';
            echo $skill . ': ';
            print_r($synonyms);
            echo '</pre>';
        }
    }
}

function printJobs()
{
    global $jobs;
    global $num_jobs;
    echo "[{( " . $num_jobs . " )}]\n";
    foreach ($jobs as $j => $job) {
        ?>
        <li>[<?php echo str_pad($job['weight'], 4, "0", STR_PAD_LEFT); ?>] <a
                    href="<?php echo $job['link']; ?>"><?php echo $job['title']; ?></a>
        </li>
        <?php
    }
}

function printSkills()
{
    global $skills;
    global $num_skills;
    echo "[{( " . $num_skills . " )}]\n";
    foreach ($skills as $skill => $weight) {
        ?>
        <li><a href="./?sort=y&tl=<?php echo urlencode($skill); ?>"><?php echo "[" . $skill . "] => " . $weight; ?></a>
        </li>
        <?php
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Career</title>
    <style>
        ul {
            padding: 5px 5px;
        }

        a:link {
            color: #00f;
            text-decoration: none;
        }

        a:visited {
            color: #f00;
            text-decoration: none;
        }

        a:hover {
            color: #0f0;
            text-decoration: underline;
        }
    </style>
</head>

<body>
<ul>
    <li>
        <a href="./">All</a><sup><a href="./?sort=y&tl=java">java</a></sup>
        <?php
        $countries = [
//            "Afghanistan" => [],
//            "Åland" => [],
//            "Albania" => [],
//            "Algeria" => [],
//            "American Samoa" => [],
//            "Andorra" => [],
//            "Angola" => [],
//            "Anguilla" => [],
//            "Antarctica" => [],
//            "Antigua and Barbuda" => [],
            "Argentina" => [],
//            "Armenia" => [],
//            "Aruba" => [],
            "Australia" => ['linux', 'agile', 'rubyonrails'],
            "Austria" => [],
//            "Azerbaijan" => [],
//            "Bahamas" => [],
//            "Bahrain" => [],
            "Bangladesh" => [],
//            "Barbados" => [],
//            "Belarus" => [],
            "Belgium" => [],
//            "Belize" => [],
//            "Benin" => [],
//            "Bermuda" => [],
//            "Bhutan" => [],
//            "Bolivia" => [],
//            "Bonaire" => [],
//            "Bosnia and Herzegovina" => [],
//            "Botswana" => [],
//            "Bouvet Island" => [],
//            "Brazil" => [],
//            "British Indian Ocean Territory" => [],
//            "British Virgin Islands" => [],
//            "Brunei" => [],
            "Bulgaria" => [],
//            "Burkina Faso" => [],
//            "Burundi" => [],
//            "Cambodia" => [],
//            "Cameroon" => [],
            "Canada" => [],
//            "Cape Verde" => [],
//            "Cayman Islands" => [],
//            "Central African Republic" => [],
//            "Chad" => [],
//            "Chile" => [],
            "China" => [],
//            "Christmas Island" => [],
//            "Cocos [Keeling] Islands" => [],
//            "Colombia" => [],
//            "Comoros" => [],
//            "Cook Islands" => [],
//            "Costa Rica" => [],
//            "Croatia" => [],
//            "Cuba" => [],
//            "Curacao" => [],
//            "Cyprus" => [],
            "Czechia" => [],
//            "Democratic Republic of the Congo" => [],
            "Denmark" => ['java'],
//            "Djibouti" => [],
//            "Dominica" => [],
//            "Dominican Republic" => [],
//            "East Timor" => [],
//            "Ecuador" => [],
//            "Egypt" => [],
//            "El Salvador" => [],
//            "Equatorial Guinea" => [],
//            "Eritrea" => [],
            "Estonia" => ['java', 'mysql', 'postgresql'],
//            "Ethiopia" => [],
//            "Falkland Islands" => [],
//            "Faroe Islands" => [],
//            "Fiji" => [],
            "Finland" => ['python'],
            "France" => [],
//            "French Guiana" => [],
//            "French Polynesia" => [],
//            "French Southern Territories" => [],
//            "Gabon" => [],
//            "Gambia" => [],
//            "Georgia" => [],
            "Germany" => ['java'],
//            "Ghana" => [],
//            "Gibraltar" => [],
//            "Greece" => [],
//            "Greenland" => [],
//            "Grenada" => [],
//            "Guadeloupe" => [],
//            "Guam" => [],
//            "Guatemala" => [],
//            "Guernsey" => [],
//            "Guinea-Bissau" => [],
//            "Guinea" => [],
//            "Guyana" => [],
//            "Haiti" => [],
//            "Heard Island and McDonald Islands" => [],
//            "Honduras" => [],
            "Hong Kong" => ['java'],
//            "Hungary" => [],
//            "Iceland" => [],
            "India" => [],
            "Indonesia" => ['react'],
//            "Iran" => [],
//            "Iraq" => [],
            "Ireland" => ['go'],
//            "Isle of Man" => [],
//            "Israel" => [],
            "Italy" => [],
//            "Ivory Coast" => [],
//            "Jamaica" => [],
            "Japan" => ['java'],
//            "Jersey" => [],
//            "Jordan" => [],
//            "Kazakhstan" => [],
//            "Kenya" => [],
//            "Kiribati" => [],
//            "Kosovo" => [],
//            "Kuwait" => [],
//            "Kyrgyzstan" => [],
//            "Laos" => [],
//            "Latvia" => [],
//            "Lebanon" => [],
//            "Lesotho" => [],
            "Liberia" => [],
//            "Libya" => [],
//            "Liechtenstein" => [],
//            "Lithuania" => [],
//            "Luxembourg" => [],
//            "Macao" => [],
//            "Macedonia" => [],
//            "Madagascar" => [],
//            "Malawi" => [],
            "Malaysia" => ['javascript'],
//            "Maldives" => [],
//            "Mali" => [],
//            "Malta" => [],
//            "Marshall Islands" => [],
//            "Martinique" => [],
//            "Mauritania" => [],
//            "Mauritius" => [],
//            "Mayotte" => [],
//            "Mexico" => [],
//            "Micronesia" => [],
//            "Moldova" => [],
//            "Monaco" => [],
//            "Mongolia" => [],
//            "Montenegro" => [],
//            "Montserrat" => [],
//            "Morocco" => [],
//            "Mozambique" => [],
//            "Myanmar [Burma]" => [],
//            "Namibia" => [],
//            "Nauru" => [],
//            "Nepal" => [],
            "Netherlands" => ['java'],
//            "New Caledonia" => [],
            "New Zealand" => [],
//            "Nicaragua" => [],
//            "Niger" => [],
//            "Nigeria" => [],
//            "Niue" => [],
//            "Norfolk Island" => [],
//            "North Korea" => [],
//            "Northern Mariana Islands" => [],
//            "Norway" => [],
//            "Oman" => [],
//            "Pakistan" => [],
//            "Palau" => [],
//            "Palestine" => [],
//            "Panama" => [],
//            "Papua New Guinea" => [],
//            "Paraguay" => [],
//            "Peru" => [],
//            "Philippines" => [],
//            "Pitcairn Islands" => [],
            "Poland" => ['c++'],
//            "Portugal" => [],
//            "Puerto Rico" => [],
//            "Qatar" => [],
//            "Republic of the Congo" => [],
//            "Réunion" => [],
//            "Romania" => [],
//            "Russia" => [],
//            "Rwanda" => [],
//            "Saint Barthélemy" => [],
//            "Saint Helena" => [],
//            "Saint Kitts and Nevis" => [],
//            "Saint Lucia" => [],
//            "Saint Martin" => [],
//            "Saint Pierre and Miquelon" => [],
//            "Saint Vincent and the Grenadines" => [],
//            "Samoa" => [],
//            "San Marino" => [],
//            "São Tomé and Príncipe" => [],
//            "Saudi Arabia" => [],
//            "Senegal" => [],
//            "Serbia" => [],
//            "Seychelles" => [],
            "Sierra Leone" => [],
            "Singapore" => ['java'],
//            "Sint Maarten" => [],
//            "Slovakia" => [],
//            "Slovenia" => [],
//            "Solomon Islands" => [],
//            "Somalia" => [],
//            "South Africa" => [],
//            "South Georgia and the South Sandwich Islands" => [],
            "South Korea" => [],
//            "South Sudan" => [],
            "Spain" => ['java', 'linux'],
//            "Sri Lanka" => [],
//            "Sudan" => [],
//            "Suriname" => [],
//            "Svalbard and Jan Mayen" => [],
//            "Swaziland" => [],
            "Sweden" => ['c++'],
            "Switzerland" => [],
//            "Syria" => [],
            "Taiwan" => [],
//            "Tajikistan" => [],
//            "Tanzania" => [],
            "Thailand" => ['c#'],
//            "Togo" => [],
//            "Tokelau" => [],
//            "Tonga" => [],
//            "Trinidad and Tobago" => [],
//            "Tunisia" => [],
            "Turkey" => [],
//            "Turkmenistan" => [],
//            "Turks and Caicos Islands" => [],
//            "Tuvalu" => [],
//            "U.S. Minor Outlying Islands" => [],
//            "U.S. Virgin Islands" => [],
//            "Uganda" => [],
//            "Ukraine" => [],
            "United Arab Emirates" => [],
            "United Kingdom" => ['javascript'],
            "United States" => ['java'],
//            "Uruguay" => [],
//            "Uzbekistan" => [],
//            "Vanuatu" => [],
//            "Vatican City" => [],
//            "Venezuela" => [],
//            "Vietnam" => [],
//            "Wallis and Futuna" => [],
//            "Western Sahara" => [],
//            "Yemen" => [],
//            "Zambia" => [],
//            "Zimbabwe" => [],
        ];
        ?>
        <ul>
            <?php
            foreach ($countries as $country => $techs) {
                ?>
                <li>
                    <a href="./?sort=y&l=<?php echo $country; ?>"><?php echo $country; ?></a>
                    <?php
                    foreach ($techs as $tech) {
                        ?>
                        <sup><a href="./?sort=y&tl=<?php echo urlencode($tech); ?>"><?php echo $tech; ?></a></sup>
                        <?php
                    }
                    ?>
                </li>
                <?php
            }
            ?>
        </ul>
        <ul>
            <li><a href="./?sort=y&s=175000&c=USD&tl=">$175,000</a></li>
            <li>
                <a href="./?sort=y&s=150000&c=USD&tl=">$150,000</a>
                <sup><a href="./?sort=y&tl=node">node</a></sup>
                <sup><a href="./?sort=y&tl=go">go</a></sup>
            </li>
            <li>
                <a href="./?sort=y&e=True">Offers Equity</a>
                <sup><a href="./?sort=y&tl=python">python</a></sup>
            </li>
        </ul>
        <ul>
            <li>
                <a href="./?sort=y&r=True">Offers Remote</a>
                <sup><a href="./?sort=y&tl=linux">linux</a></sup>
            </li>
            <li>
                <a href="./?sort=y&v=True">Visa Sponsorship</a>
                <sup><a href="./?sort=y&tl=java">java</a></sup>
            </li>
            <li>
                <a href="./?sort=y&t=True">Offers Relocation</a>
                <sup><a href="./?sort=y&tl=java">java</a></sup>
            </li>
        </ul>
        <ul>
            <li><a href="./?sort=y&ms=Student&mxs=Student"><strong>Student</strong></a></li>
            <li><a href="./?sort=y&ms=Student&mxs=Junior">Student ⋯ Junior</a></li>
            <li><a href="./?sort=y&ms=Student&mxs=MidLevel">Student ⋯ MidLevel</a></li>
            <li><a href="./?sort=y&ms=Student&mxs=Senior">Student ⋯ Senior</a></li>
            <li><a href="./?sort=y&ms=Student&mxs=Lead">Student ⋯ Lead</a></li>
            <li><a href="./?sort=y&ms=Student&mxs=Manager">Student ⋯ Manager</a></li>
        </ul>
        <ul>
            <li><a href="./?sort=y&ms=Junior&mxs=Junior"><strong>Junior</strong></a></li>
            <li><a href="./?sort=y&ms=Junior&mxs=MidLevel">Junior ⋯ MidLevel</a></li>
            <li><a href="./?sort=y&ms=Junior&mxs=Senior">Junior ⋯ Senior</a></li>
            <li><a href="./?sort=y&ms=Junior&mxs=Lead">Junior ⋯ Lead</a></li>
            <li><a href="./?sort=y&ms=Junior&mxs=Manager">Junior ⋯ Manager</a></li>
        </ul>
        <ul>
            <li><a href="./?sort=y&ms=MidLevel&mxs=MidLevel"><strong>MidLevel</strong></a></li>
            <li><a href="./?sort=y&ms=MidLevel&mxs=Senior">MidLevel ⋯ Senior</a></li>
            <li><a href="./?sort=y&ms=MidLevel&mxs=Lead">MidLevel ⋯ Lead</a></li>
            <li><a href="./?sort=y&ms=MidLevel&mxs=Manager">MidLevel ⋯ Manager</a></li>
        </ul>
        <ul>
            <li><a href="./?sort=y&ms=Senior&mxs=Senior"><strong>Senior</strong></a></li>
            <li><a href="./?sort=y&ms=Senior&mxs=Lead">Senior ⋯ Lead</a></li>
            <li><a href="./?sort=y&ms=Senior&mxs=Manager">Senior ⋯ Manager</a></li>
        </ul>
        <ul>
            <li><a href="./?sort=y&ms=Lead&mxs=Lead"><strong>Lead</strong></a></li>
            <li><a href="./?sort=y&ms=Lead&mxs=Manager">Lead ⋯ Manager</a></li>
        </ul>
        <ul>
            <li>
                <a href="./?sort=y&ms=Manager&mxs=Manager"><strong>Manager</strong></a>
                <sup><a href="./?sort=y&tl=javascript">javascript</a></sup>
            </li>
        </ul>
        <ul>
            <li><a href="./?sort=y&dr=BackendDeveloper">Backend Developer</a>
                <sup><a href="./?sort=y&tl=java">java</a></sup>
            </li>
            <li>
                <a href="./?sort=y&dr=DataScientist">Data Scientist</a>
                <sup><a href="./?sort=y&tl=machinelearning">machinelearning</a></sup>
            </li>
            <li><a href="./?sort=y&dr=DatabaseAdministrator">Database Administrator</a>
                <sup><a href="./?sort=y&tl=mysql">mysql</a></sup>
                <sup><a href="./?sort=y&tl=linux">linux</a></sup>
                <sup><a href="./?sort=y&tl=python">python</a></sup>
                <sup><a href="./?sort=y&tl=sql">sql</a></sup>
            </li>
            <li><a href="./?sort=y&dr=Designer">Designer</a>
                <sup><a href="./?sort=y&tl=userinterface">userinterface</a></sup>
            </li>
            <li><a href="./?sort=y&dr=DesktopDeveloper">Desktop Developer</a>
                <sup><a href="./?sort=y&tl=<?php echo urlencode('c++'); ?>">c++</a></sup>
            </li>
            <li><a href="./?sort=y&dr=DevOpsDeveloper">DevOps Developer</a>
                <sup><a href="./?sort=y&tl=amazonwebservices">amazonwebservices</a></sup>
            </li>
            <li><a href="./?sort=y&dr=FrontendDeveloper">Frontend Developer</a>
                <sup><a href="./?sort=y&tl=javascript">javascript</a></sup>
            </li>
            <li><a href="./?sort=y&dr=FullStackDeveloper">Full Stack Developer</a>
                <sup><a href="./?sort=y&tl=javascript">javascript</a></sup>
            </li>
            <li><a href="./?sort=y&dr=GameDeveloper">Graphics/Game Developer</a>
                <sup><a href="./?sort=y&tl=<?php echo urlencode('c++'); ?>">c++</a></sup>
            </li>
            <li><a href="./?sort=y&dr=MobileDeveloper">Mobile Developer</a>
                <sup><a href="./?sort=y&tl=android">android</a></sup>
            </li>
            <li><a href="./?sort=y&dr=ProductManager">Product Manager</a>
                <sup><a href="./?sort=y&tl=java">java</a></sup>
            </li>
            <li><a href="./?sort=y&dr=QATestDeveloper">QA/Test Developer</a>
                <sup><a href="./?sort=y&tl=java">java</a></sup>
            </li>
            <li><a href="./?sort=y&dr=SystemAdministrator">System Administrator</a>
                <sup><a href="./?sort=y&tl=linux">linux</a></sup>
            </li>
        </ul>
        <ul>
            <li>
                <a href="./?sort=y&j=permanent">Permanent</a>
                <sup><a href="./?sort=y&tl=java">java</a></sup>
            </li>
            <li><a href="./?sort=y&j=contract">Contract</a></li>
            <li><a href="./?sort=y&j=internship">Internship</a></li>
        </ul>
    </li>
</ul>

<?php
printSynonyms();
$picked1 = getRandomWeightedElement($skills, $num_skills);
echo "({[ " . $picked1 . ":" . $skills[$picked1] . " ]})\n";
echo "<br />";
//print_r($skills);
echo "<br />";
if (count($jobs) > count($skills)) {
    printSkills();
    printJobs();
} else {
    printJobs();
    printSkills();
}
?>
</body>
</html>
