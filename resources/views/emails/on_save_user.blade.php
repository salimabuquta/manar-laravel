<html>
<body style="background-color: #f1f1f1">
<table width="100%">
    <tbody>
    <tr>
        <td valign="center" align="center" style="padding:100px 0">
            <table style="width:70%;background:white;" cellpadding="0" cellspacing="0">
                <tbody>
                <tr style="background-color:rgba(0,0,0,0.31)!important">
                    <td>
                        <h3 style="color:white;text-align:center;font-size:25px">
                            Welcome to Laravel.test
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px;">
                        <br>
                        <h3 style="text-align: left;margin: 0;">
                            <span>Hello</span>
                            <span>{{ $user->name }}</span>,
                        </h3>
                        <p style="
    margin: 0;
">
                            Congratulations! Your account has been activated, you may use the system now
                        </p>
                        <br>
                        <div style="direction: rtl; text-align: right;">
                            <h3 style="text-align: right;margin: 0;">
                                <span>مرحبا</span>
                                <span>{{ $user->name }}</span>,
                            </h3>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>