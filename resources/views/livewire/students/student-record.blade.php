<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Ficha individual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
        <tr>
            <td align="center" bgcolor="#cccccc" style="padding: 20px 0 20px 0;">
                <img width="10%" src="{{ url('storage/logos-school/logo-header.png') }}" alt="Feliz aniversário."
                    style="display: block;" />
                <h4 style="margin: 0; padding: 0; font-family:arial; color:#292626;">{{ $config->nick }}</h4>
                <h6 style="margin: 0; padding: 0;font-family:arial; color:rgb(61, 58, 58)626;">
                    {{ $config->name }}
                </h6>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="260" valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 10px 0 0 0; font-family:arial;">
                                        <h4>Senhor(a) Responsável, boa dia.</h4>
                                        <p>
                                            Encaminho ao seu conhecimento a Ficha Individual do seu
                                            dependente.
                                        </p>
                                        <p>
                                            Nela, constam informações importantes para o acompanhamento pelos
                                            Responsáveis, dentre elas, o grau de comportamento, medidas disciplinares e
                                            o percentual de faltas.
                                        </p>
                                        <p>
                                            Respeitosamente,
                                        </p>
                                        <p>
                                            Comandante da {{ strtolower($company->name) }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="260" valign="top">
                *Caso você não queira mais receber nossos emails informe a {{ strtolower($company->name) }}.
            </td>
        </tr>

    </table>
</body>

</html>
