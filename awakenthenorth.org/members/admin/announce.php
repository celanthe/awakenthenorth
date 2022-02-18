<?PHP
error_reporting(E_ALL);
require("../db.php");
$webhookurl = "https://discord.com/api/webhooks/802237112631951420/3ytYieaLswM42PhHCIb8M3hS-HZqPL9n4_hKkxfecBGGrT0wOP7fBvHxbG9MZnoA_5Ep";

//=======================================================================================================
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================
$members=MDB::query("SELECT * FROM atn_cmr WHERE `discord` = 0 ORDER BY id ASC");
if ($members) {
$mem=$members[0];
if (empty($mem["pname"])) { $minfo=$mem["first"]." ".$mem["last"]; } else { $minfo=$mem["first"]." ".$mem["last"].". Preferred Name: ".$mem["pname"]; }
$timestamp = date("c", strtotime("now"));
$json_data = json_encode([
    // Message
    "content" => "New Member: ".$minfo,
    
    // Username
    "username" => "Herald",

    // Avatar URL.
    // Uncoment to replace image set in webhook
    //"avatar_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=512",

    // Text-to-speech
    "tts" => false,

    // File upload
    // "file" => "",

    

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
curl_close( $ch );
echo "Announced: ".$mem["first"]." ".$mem["last"].". Preferred Name: ".$mem["pname"];
MDB::update("atn_cmr", array("discord"=>1), "id=%i", $mem["id"]);
} else {
	echo "No one to announce.";
}
?>