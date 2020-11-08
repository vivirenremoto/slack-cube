<?php

/*

1. crear app en slack
https://api.slack.com/apps?new_app=1

2. seleccionar permisos: User Token Scopes - users.profile:write
https://api.slack.com/apps/A01A60XRMLK/oauth?

3. instalar app para obtener el token
https://api.slack.com/apps/A01A60XRMLK/oauth?

4. crear script

 */

/*

docs

https://stackoverflow.com/questions/30426047/correct-way-to-set-bearer-token-with-curl

https://api.slack.com/methods/users.profile.set

https://api.slack.com/docs/presence-and-status

https://slack.com/intl/es-la/help/articles/202931348-C%C3%B3mo-usar-emojis-y-emoticonos

https://www.webfx.com/tools/emoji-cheat-sheet/

 */

$token = '';

//////////////////////////////////////////////////

$status = isset($_POST['status']) ? current(explode(';', $_POST['status'])) : 'normal';

$url = 'https://slack.com/api/users.profile.set';

$data = array();
$data['profile']['status_expiration'] = 0;

switch ($status) {
    case 'izquierda':
        $data['profile']['status_text'] = 'ausente temporalmente';
        $data['profile']['status_emoji'] = ':clock2:';
        break;

    case 'derecha':
        $data['profile']['status_text'] = 'reunido';
        $data['profile']['status_emoji'] = ':calendar:';
        break;

    case 'adelante':
        $data['profile']['status_text'] = 'ocupado';
        $data['profile']['status_emoji'] = ':fire:';
        break;

    case 'atras':
        $data['profile']['status_text'] = 'llamada';
        $data['profile']['status_emoji'] = ':phone:';
        break;

    case 'abajo':
        $data['profile']['status_text'] = 'comiendo';
        $data['profile']['status_emoji'] = ':hamburger:';
        break;

    //normal
    default:
        $data['profile']['status_text'] = '';
        $data['profile']['status_emoji'] = '';
        break;
}

$data_string = json_encode($data);

$ch = curl_init();

$headers = array();
$headers[] = 'Content-type: application/json';
$headers[] = 'Authorization: Bearer ' . $token;

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
$result = curl_exec($ch);

curl_close($ch);

echo '<pre>';
print_r($result);
