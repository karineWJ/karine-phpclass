<?php 
//so the b<? in the xml tag doesn't break php
echo '<?xml version="1.0" encoding="utf-8"?>'; 
//connect to DB
require('includes/config.php');
?>
<rss version="2.0">
	<channel>
		<title>Allure's Feed</title>
		<link>http://localhost/karine-phpclass/allure/</link>
		<description>RSS Feed from Allure</description>

		<?php //get up to 10 most recent published photos  
		$query = "SELECT photos.photo_id, photos.photo_link, photos.description, photos.date, users.username
				  FROM photos, users
				  WHERE photos.user_id = users.user_id
				  ORDER BY photos.date DESC
				  LIMIT 10";
		$result = $db->query($query);

		if( $result->num_rows >= 1 ){
			while( $row = $result->fetch_assoc() ){
		 ?>

		 <item>
			<title><?php echo $row['description']; ?></title>
			<link>http://localhost/karine-phpclass/allure/single-post.php?photo_id=<?php echo $row['photo_id']; ?></link>
			<guid>http://localhost/karine-phpclass/allure/single-post.php?photo_id=<?php echo $row['photo_id']; ?></guid>
			<description><![CDATA[ <img src="<?php echo 'http://localhost/karine-phpclass/allure' . $row['photo_link'] ?>"> ]]></description>
			<author><?php echo $row['username']; ?></author>
			<pubDate><?php echo $row['date']; ?></pubDate>
		</item>

		<?php 
			} //end while
		} //end if ?>

	</channel>

</rss>