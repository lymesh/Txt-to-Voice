<?php
// 检查是否提交了表单
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apiKey']) && isset($_POST['apiUrl']) && isset($_POST['text']) && isset($_POST['voice'])) {
    // 从表单获取数据
    $apiKey = $_POST['apiKey'];
    $apiUrl = $_POST['apiUrl'];
    $text = $_POST['text'];
    $voice = $_POST['voice'];

    // 设置 cURL 请求
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => 'tts-1',
        'input' => $text,
        'voice' => $voice
    ]));

    // 发送请求并获取响应
    $response = curl_exec($ch);

    // 检查是否有错误发生
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // 设置适当的 HTTP 头信息以触发浏览器下载
        header('Content-Type: audio/mpeg');
        header('Content-Disposition: attachment; filename="txt_to_speech.mp3"');
        header('Content-Length: ' . strlen($response));

        // 输出响应内容（即 MP3 文件的内容）
        echo $response;
    }

    // 关闭 cURL 会话
    curl_close($ch);

    // 结束脚本以避免发送任何额外的输出
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPT文本转语音</title>
    <!-- 引入 Tailwind CSS -->
    
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

</head>
<body class="flex flex-col min-h-screen">
    <div class="flex-grow">
    <div class="container mx-auto p-8">
        <h1 class="text-xl font-semibold text-gray-700 mb-6">OPENAI文本转语音</h1>
        <form action="" method="post" class="bg-white shadow-lg rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="apiUrl" class="block text-gray-700 text-sm font-bold mb-2">输入请求地址：</label>
                <input type="text" id="apiUrl" name="apiUrl" value="https://api.openai.com/v1/audio/speech" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="apiKey" class="block text-gray-700 text-sm font-bold mb-2">输入您的 OpenAI API 密钥：</label>
                <input type="text" id="apiKey" name="apiKey" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="text" class="block text-gray-700 text-sm font-bold mb-2">请输入要转换的文本：</label>
                <textarea name="text" id="text" rows="4" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">请输入要转换的文本...</textarea>
            </div>

            <div class="mb-6">
                <label for="voice" class="block text-gray-700 text-sm font-bold mb-2">选择声音：</label>
                <select name="voice" id="voice" class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="alloy">Alloy</option>
                    <option value="echo">Echo</option>
                  
            <option value="fable">Fable</option>
            <option value="onyx">Onyx</option>
            <option value="nova">Nova</option>
            <option value="shimmer">Shimmer</option>
                    <!-- 其他选项 -->
                </select>
            </div>

            <div class="flex items-center justify-between">
                <input type="submit" value="转换为音频并下载" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>
        </form>
    </div>
    </div>
     <!-- 页面底部 -->
     <footer class="bg-white text-gray-800 text-center p-4">
        <p>
            By<a href="https://github.com/lymesh/Txt-to-Voice" class="text-blue-300 hover:text-blue-500" target="_blank">探索分享</a> 
        </p>
    </footer>
</body>
</html>
