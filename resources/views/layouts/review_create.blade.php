<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>レビュー投稿画面</title>
</head>
<body>
<h1>レビュー投稿画面</h1>
<form action="/posts" method="POST">
@csrf
<div class="title">
<h2>タイトル</h2>
<input type="text" name="post[title]" placeholder="タイトル"/>
</div>
<div class="body">
<h2>本文</h2>
<textarea name="post[body]" placeholder="今日も1日お疲れさまでした。"></textarea>
</div>
<input type="submit" value="投稿"/>
</form>
<div class="footer">
<a href="/">戻る</a>
</div>
</body>
</html>