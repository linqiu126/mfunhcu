<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/2
 * Time: 20:45
 */

header("Content-type:text/html;charset=utf-8");
echo "<H1>WELCOME! 上海小慧智能科技欢迎您！<br><br>";
echo "<H2>后台二维码制作工具<br>";
?>


<!DOCTYPE HTML>
<html>
<body>

<p>
<H3>根据MAC地址生成二维码，微信扫码后即关注，硬件蓝牙连通后自动绑定：</H3>
<form action=" tool.qrcode.gen.php" method="post">
    硬件MAC地址：<input type="text" name="mac_address"><br>
    未来参数 一：<input type="number" name="parameter1"><br>
    未来参数 二：<input type="date" name="parameter2"><br>
    未来参数 三：<input type="radio" name="parameter3"><br>
    未来参数 四：<input type="file" name="parameter4"><br>
    未来参数 五：<input type="color" name="parameter5"><br>
    未来参数 六：<input type="url" name="parameter6"><br>
    未来参数 七：<input type="button" name="parameter7"><br>
    <input type="submit">
</form>
</p>

<p>
<H3>后台强制绑定：</H3>
<form action="tool.dev.bind.php" method="post">
    硬件设备DeviceID：<input type="text" name="deviceid"><br>
    硬件设备Qrcode：<input type="text" name="qrcode"><br>
    硬件设备MAC：<input type="text" name="mac"><br>
    微信用户OpenID：<input type="text" name="openid"><br>
    <input type="submit">
</form>
</p>

<p>
<H3>重新生成菜单：</H3>
<form action="tool.create.menu.php" method="post">
    未来参数一：<input type="text" name="par1"><br>
    未来参数二：<input type="text" name="par2"><br>
    <input type="submit">
</form>
</p>


</body>
</html>
