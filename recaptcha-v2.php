/* This function triggers when the submit button is clicked in the front end */
public function submit(){
    $validate = $this->validateToken($_POST["g-recaptcha-response"]);;
    if (isset($validate->success)) {
        $success = $validate->success;
        if ($success == false) {
            print_r("It seems we can't validate your submission, please check google verification box");
        }
    } else {
        print_r("It seems there has been an error, please reload this page.");
    }
}

/* This function evaluates the token passed from the fron end (using site key) agaisnt the SECRET KEY and the Google reCaptcha API
 If successul, it will return true.*/
function validateToken($token) {
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"secret\"\r\n\r\n".$SECRET_KEY."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"response\"\r\n\r\n".$token."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"postman-token: e9ab920d-e441-9519-ac05-da14df852190"
			),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			return false;
		} else {
			return true;
		}
	}
