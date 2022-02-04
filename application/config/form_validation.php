<?php
$config = array(
        'signup' => array(
                array(
                        'field' => 'fname',
                        'label' => 'firstname',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'lname',
                        'label' => 'lastname',
                        'rules' => 'required'
                ),
				array(
					'field' => 'uname',
					'label' => 'username',
					'rules' => 'required'
				)
        ),
        'login' => array(
                array(
                        'field' => 'username',
                        'label' => 'username',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'password',
                        'label' => 'password',
                        'rules' => 'required|min_length[8]'
                )
        
        ),
		'changePassword' => array(
			array(
				'field' => 'opw',
				'label' => 'oldpassword',
				'rules' => 'required'
			),
			array(
				'field' => 'npw',
				'label' => 'New password',
				'rules' => 'required|min_length[8]'
			),
			array(
				'field' => 'cnpw',
				'label' => 'New password Confirmation',
				'rules' => 'required|min_length[8]|matches[npw]'
			)

		),
		'editpreference' => array(
			array(
				'field' => 'nst',
				'label' => 'notice show time',
				'rules' => 'required'
			),
			array(
				'field' => 'nist',
				'label' => 'notice image show time',
				'rules' => 'required'
			),
			array(
				'field' => 'nrt',
				'label' => 'notices reload time',
				'rules' => 'required'
			)
		)

);

$config['error_prefix'] = '<div class="text-danger">';
$config['error_suffix'] = '</div>';

?>
