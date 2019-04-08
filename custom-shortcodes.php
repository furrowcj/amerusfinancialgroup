<?php
function get_rank()
{
	$current_user_id = get_current_user_id();
	$rank = get_user_meta( $current_user_id,'rank',True );
	if ($rank == null)
		echo 'Field Agent';
	else
		echo $rank;
}
add_shortcode('get_rank', 'get_rank');


function print_topfive()
{
/*$topfive = (get_topfive());

for($x = 0; x <= 5; $x++) 
{
    echo $topfive[$x], '<br>';
}*/
$topfive = array('','','','','');
 
for ($x = 0;$x < 5;$x++)
{
$args = array(
	'blog_id'      => 2,
	'role'         => 'subscriber',
	'role__in'     => array(),
	'role__not_in' => array(),
	'meta_key'     => '',
	'meta_value'   => '',
	'meta_compare' => '',
	'meta_query'   => array(),
	'date_query'   => array(),        
	'include'      => array(),
	'exclude'      => $topfive,
	'orderby'      => 'login',
	'order'        => 'ASC',
	'offset'       => '',
	'search'       => '',
	'number'       => '',
	'count_total'  => false,
	'fields'       => 'all',
	'who'          => '',
 );
	$subusers = get_users( $args );
	$topuser = 0;
	$lastproduction = 0;
	foreach ($subusers as $user)
	{
		$user_id = ($user->ID);
		$yrlyproduction = get_user_meta( $user->ID,'yrlyproduction',True );
		if ($yrlyproduction > $lastproduction)
		{
			$topuser = $user->ID;
		}
		$lastproduction = $yrlyproduction;	
	}
	$topfive[$x] = $topuser;
	$avatar = get_avatar($topuser);
	$user_info = get_userdata($topuser);
	$first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
	$k = $x + 1;
	echo "<h2>$k. $avatar $first_name $last_name <br></h2>";
}
}

add_shortcode('print_topfive', 'print_topfive');


function print_yrlyproduction()
{
 $current_user = wp_get_current_user();
$current_email = $current_user->user_email;
$annual_prem_string = '_field_annual-prem__';
$tota_annual_prem = 0;
$current_year = date("Y");


$args = array(
    'post_type' => 'flamingo_inbound',
    'meta_query' => array(
		array(
			'key' => '_field_agent-email',
			'value' => $current_email,
		),
	)
);

$all_production = get_posts( $args, ARRAY_A );



foreach($all_production as $production){
	$app_yeardate = get_post_meta($production->ID, '_field_today-date',true );
 if((substr($app_yeardate,0,4)) == $current_year)
{
	$total_core_apps = get_post_meta($production->ID, '_field_total-core-apps',true );
	for ($i = 1; $i <= $total_core_apps; $i++)
	{
	$annual_prem = get_post_meta($production->ID, $annual_prem_string.$i ,true );
	$total_annual_prem += $annual_prem;
	}
}

}
echo '$';
echo number_format($total_annual_prem, 2, '.', ',');
}
add_shortcode('print_yrlyproduction', 'print_yrlyproduction');

function print_qtrproduction()
{
 $current_user = wp_get_current_user();
$current_email = $current_user->user_email;
$annual_prem_string = '_field_annual-prem__';
$tota_annual_prem = 0;
$curMonth = date("m", time());
$curQuarter = ceil($curMonth/3);


$args = array(
    'post_type' => 'flamingo_inbound',
    'meta_query' => array(
		array(
			'key' => '_field_agent-email',
			'value' => $current_email,
		),
	)
);

$all_production = get_posts( $args, ARRAY_A );



foreach($all_production as $production){
	$app_date = get_post_meta($production->ID, '_field_today-date',true );
	$appMonth = substr($app_date,5,7);
	$appQuarter = ceil($appMonth/3);
 if($appQuarter == $curQuarter)
{
	$total_core_apps = get_post_meta($production->ID, '_field_total-core-apps',true );
	for ($i = 1; $i <= $total_core_apps; $i++)
	{
	$annual_prem = get_post_meta($production->ID, $annual_prem_string.$i ,true );
	$total_annual_prem += $annual_prem;
	}
}

}
echo '$';
echo number_format($total_annual_prem, 2, '.', ',');
}
add_shortcode('print_qtrproduction', 'print_qtrproduction');


function get_qtrproduction()
{
 $current_user = wp_get_current_user();
$current_email = $current_user->user_email;
$annual_prem_string = '_field_annual-prem__';
$tota_annual_prem = 0;
$curMonth = date("m", time());
$curQuarter = ceil($curMonth/3);


$args = array(
    'post_type' => 'flamingo_inbound',
    'meta_query' => array(
		array(
			'key' => '_field_agent-email',
			'value' => $current_email,
		),
	)
);

$all_production = get_posts( $args, ARRAY_A );



foreach($all_production as $production){
	$app_date = get_post_meta($production->ID, '_field_today-date',true );
	$appMonth = substr($app_date,5,7);
	$appQuarter = ceil($appMonth/3);
 if($appQuarter == $curQuarter)
{
	$total_core_apps = get_post_meta($production->ID, '_field_total-core-apps',true );
	for ($i = 1; $i <= $total_core_apps; $i++)
	{
	$annual_prem = get_post_meta($production->ID, $annual_prem_string.$i ,true );
	$total_annual_prem += $annual_prem;
	}
}

}
return $total_annual_prem;
}
add_shortcode('get_qtrproduction', 'get_qtrproduction');


function bonus_qualified()
{
	$bonus = "Not Qualified";

	if(get_qtrproduction() >= 30000)
	{
		$bonus = "Qualified";
	}

	echo $bonus;
}

add_shortcode('bonus_qualified', 'bonus_qualified');


function print_applications()
{
$current_user = wp_get_current_user();
$current_email = $current_user->user_email;

$args = array(
    'post_type' => 'flamingo_inbound',
    'meta_query' => array(
		array(
			'key' => '_field_agent-email',
			'value' => $current_email,
		),
	)
);

$all_production = get_posts( $args, ARRAY_A );



echo '<table style="border:1px solid black; text-align: center; padding-top: 50px;"><thead style="border:1px solid black; color:#FFF; background-color: #00adee;"><th>Reported Date</th><th>First Name</th><th>Last Name</th><th>Issue Date</th><th>Company Name</th><th>Product Type</th><th>Annual Premium</th></thead><tbody>';
foreach($all_production as $production){
	
	$total_core_apps = get_post_meta($production->ID, '_field_total-core-apps',true );
	$total_other_apps = get_post_meta($production->ID, '_field_total-other-apps',true );
	$report_date = get_post_meta($production->ID, '_field_today-date',true );
 
	if ($total_core_apps > 0)
	{
	for ($i = 1; $i <= $total_core_apps; $i++)
	{
	echo '<tr style="border:1px solid black;">';
	echo '<td>' . $report_date . '</td>';
	$first_name = get_post_meta($production->ID, '_field_client-first-name__'.$i, true );
	$last_name = get_post_meta($production->ID, '_field_client-last-name__'.$i,true );
	$company = get_post_meta($production->ID, '_field_app-company__'.$i,true );
	$prod_type = get_post_meta($production->ID, '_field_app-type__'.$i,true );
	$issue_date = get_post_meta($production->ID, '_field_issue-date__'.$i,true );
	$annual_prem = get_post_meta($production->ID, '_field_annual-prem__'.$i,true );
	
	echo '<td>' . $first_name . '</td>';
	echo '<td>' . $last_name . '</td>';
	echo '<td>' . $issue_date . '</td>';
	foreach($company as $comp)
	{echo '<td>' . $comp . '</td>';}
	echo '<td>' . $prod_type . '</td>';
	echo '<td>$' . number_format($annual_prem, 2, '.', ',') . '</td>';
	echo '</tr>';
	}
	}

	if ($total_other_apps > 0)
	{
	for ($i = 1; $i <= $total_other_apps; $i++)
		{
	echo '<tr style="border:1px solid black;">';
        echo '<td>' . $report_date . '</td>';
	$first_name = get_post_meta($production->ID, '_field_clientother-first-name__'.$i,true );
	$last_name = get_post_meta($production->ID, '_field_clientother-last-name__'.$i,true );
	$company = get_post_meta($production->ID, '_field_other-app-company__'.$i,true );
	$prod_type = get_post_meta($production->ID, '_field_other-app-type__'.$i,true );
	$issue_date = get_post_meta($production->ID, '_field_other-issue-date__'.$i,true );
	$annual_prem = get_post_meta($production->ID, '_field_other-annual-prem__'.$i,true );
	
	echo '<td>' . $first_name . '</td>';
	echo '<td>' . $last_name . '</td>';
	echo '<td>' . $issue_date . '</td>';
	foreach($company as $comp)
	{echo '<td>' . $comp . '</td>';}
	echo '<td>' . $prod_type . '</td>';
	echo '<td>$' . number_format($annual_prem, 2, '.', ',') . '</td>';
	echo '</tr>';
		}
	}
}
echo '</tbody></table>';
}

add_shortcode('print_applications', 'print_applications');

function print_hierarchy()
{
	$current_user_id = get_current_user_id();
	$agent_above = get_user_meta( $current_user_id,'agent_above',True );
	$agent_under1 = get_user_meta( $current_user_id,'agent_under1',True );
	$agent_under2 = get_user_meta( $current_user_id,'agent_under2',True );
	$agent_under3 = get_user_meta( $current_user_id,'agent_under3',True );
	$agent_under4 = get_user_meta( $current_user_id,'agent_under4',True );
	$agent_under5 = get_user_meta( $current_user_id,'agent_under5',True );

	
	
}
add_shortcode('print_applications', 'print_applications');
?>