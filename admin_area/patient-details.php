<?php

session_start();

include("includes/db.php");
include("includes/header.php");

if (isset($_GET['patientID'])) {
	$patient_id = $_GET['patientID'];
	$sql_id = "SELECT * FROM patient WHERE patientID = " . $patient_id;
	$sql_comorbidity = "SELECT * FROM comorbidities WHERE patientID = " . $patient_id;
	$sql_symptom = "SELECT * FROM symptom WHERE patientID = " . $patient_id;
	$result_id = mysqli_query($conn1, $sql_id);
	$result_symptom = mysqli_query($conn1, $sql_symptom);
	$result_comorbidity = mysqli_query($conn1, $sql_comorbidity);
	if (mysqli_num_rows($result_id) > 0) {
		while ($row = mysqli_fetch_assoc($result_id)) {
			$row_comorbidity = mysqli_fetch_assoc($result_comorbidity);
			$row_symptom = mysqli_fetch_assoc($result_symptom);
			?>

			<body>



				<div id="preloader">
					<div class="sk-three-bounce">
						<div class="sk-child sk-bounce1"></div>
						<div class="sk-child sk-bounce2"></div>
						<div class="sk-child sk-bounce3"></div>
					</div>
				</div>

				<div id="main-wrapper">


					<?php

					include("includes/navhead.php");

					?>

					<?php

					include("includes/main.php");

					?>

					<?php

					include("includes/sidebar.php");

					?>

					<div class="content-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-12">
									<div class="form-head page-titles d-flex align-items-center mb-sm-4 mb-3">
										<div class="mr-auto">
											<h2 class="text-black font-w600">Patient Details</h2>
											<nav aria-label="breadcrumb">
												<ol class="breadcrumb">
													<li class="breadcrumb-item active"><a
															href="table-datatable-basic.php?status=all">Patient</a></li>
													<li class="breadcrumb-item">
														<?php echo $row["fullName"]; ?>
													</li>
												</ol>
											</nav>
										</div>
										<div class="ml-auto">
											<div class="btn-group mr-3">
												<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
													aria-haspopup="true" aria-expanded="false">
													In Treatment
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item"
														href="patient_delete.php?patientID= <?php echo $patient_id; ?>">Delete</a>
												</div>
											</div>
											<a class="btn btn-outline-primary" data-toggle="modal"
												data-target="#addOrderModal">Update Profile</a>
											<a href="report.php?patientID=<?php echo $patient_id ?>"
												class="btn btn-primary btn-lg ml-2">Print</a>
										</div>
									</div>
								</div>
							</div>

							<div class="modal fade" id="addOrderModal">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Update Profile</h5>
											<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
											</button>
										</div>
										<?php echo '
										<div class="modal-body">
											<form action="update_patient.php?" method="get">

												<input type="hidden" name="patientID" value="' . $patient_id . '">

												<div class="form-group">
													<label class="text-black font-w500" name="name">Patient Name</label>
													<input type="text" class="form-control" name="fullname"
														value="' . $row["fullName"] . '"><br>
													<br><label class="text-black font-w500" name="gender">Gender</label>
													<select class="form-control" type="text" name="gender">
														<option selected>Choose Gender ...</option>
														<option value="Male" ' . ($row["gender"] == "Male" ? "selected" : "") . '>Male</option>
														<option value="Female" ' . ($row["gender"] == "Female" ? "selected" : "") . '>Female</option>
													</select>
												</div>
										
												<div class="form-group">
													<label class="text-black font-w500" require>Comorbidities</label><br>
													To select multiple, hold down the Ctrl key and select
													<select class="form-control" name="comorbidities[]" size="5" multiple="multiple">
														<option value="Older Age" ' . ($row_comorbidity["comorbidityName"] == "Older Age" ? "selected" : "") . '>Older Age</option>
														<option value="Lung problems, including asthma" ' . ($row_comorbidity["comorbidityName"] == "Lung problems, including asthma" ? "selected" : "") . '>Lung problems, including asthma</option>
														<option value="Heart disease" ' . ($row_comorbidity["comorbidityName"] == "Heart disease" ? "selected" : "") . '>Heart disease</option>
														<option value="Brain and nervous system conditions" ' . ($row_comorbidity["comorbidityName"] == "Brain and nervous system conditions" ? "selected" : "") . '>Brain and nervous system conditions</option>
														<option value="Diabetes and obesity" ' . ($row_comorbidity["comorbidityName"] == "Diabetes and obesity" ? "selected" : "") . '>Diabetes and obesity</option>
														<option value="Cancer and certain blood disorders" ' . ($row_comorbidity["comorbidityName"] == "Cancer and certain blood disorders" ? "selected" : "") . '>Cancer and certain blood disorders</option>
														<option value="Weakened immune system" ' . ($row_comorbidity["comorbidityName"] == "Weakened immune system" ? "selected" : "") . '>Weakened immune system</option>
														<option value="Chronic kidney or liver disease" ' . ($row_comorbidity["comorbidityName"] == "Chronic kidney or liver disease" ? "selected" : "") . '>Chronic kidney or liver disease</option>
														<option value="Mental health conditions" ' . ($row_comorbidity["comorbidityName"] == "Mental health conditions" ? "selected" : "") . '>Mental health conditions</option>
														<option value="Down syndrome" ' . ($row_comorbidity["comorbidityName"] == "Down syndrome" ? "selected" : "") . '>Down syndrome</option>
													</select><br>
												</div>

												<div class="form-group">
													<label class="text-black font-w500">Symptoms</label><br>
													To select multiple, hold down the Ctrl key and select
													<select class="form-control" name="symptom[]" size="5" multiple="multiple">
														<option value="Cough" ' . ($row_symptom["symptomsName"] == "Cough" ? "selected" : "") . '>Cough</option>
														<option value="Headache" ' . ($row_symptom["symptomsName"] == "Headache" ? "selected" : "") . '>Headache</option>
														<option value="Fatigue" ' . ($row_symptom["symptomsName"] == "Fatigue" ? "selected" : "") . '>Fatigue</option>
														<option value="Shortness of breath or difficulty breathing" ' . ($row_symptom["symptomsName"] == "Shortness of breath or difficulty breathing" ? "selected" : "") . '>
															Shortness of breath or difficulty breathing
														</option>
														<option value="Muscle or body aches" ' . ($row_symptom["symptomsName"] == "Muscle or body aches" ? "selected" : "") . '>Muscle or body aches</option>
														<option value="Sore throat" ' . ($row_symptom["symptomsName"] == "Sore throat" ? "selected" : "") . '>Sore throat</option>
														<option value="Congestion or runny nose" ' . ($row_symptom["symptomsName"] == "Congestion or runny nose" ? "selected" : "") . '>
															Congestion or runny nose
														</option>
														<option value="Nausea or vomiting" ' . ($row_symptom["symptomsName"] == "Nausea or vomiting" ? "selected" : "") . '>Nausea or vomiting</option>
														<option value="Diarrhea" ' . ($row_symptom["symptomsName"] == "Diarrhea" ? "selected" : "") . '>Diarrhea</option>
													</select><br>
												</div>

												<div class="form-group">
													<label class="text-black font-w500">Contact (Phone Number)</label>
													<input type="text" class="form-control" name="phone" value="' . $row["phone"] . '">
												</div>

												<div class="form-group">
													<label class="text-black font-w500">Address</label>
													<input type="text" class="form-control" name="address" value="' . $row["address"] . '">
												</div>

												<div class="form-group">
													<button type="submit" class="btn btn-primary" name="update_patient">UPDATE</button>
												</div>

											</form>
										</div>
										'
											?>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xl-9 col-xxl-12">
									<div class="row">
										<div class="col-xl-12">
											<div class="card details-card">
												<img src="images\patient_background.jpg" alt="" class="bg-img">
												<div class="card-body">
													<div class="d-sm-flex mb-3">
														<div class="img-card mb-sm-0 mb-3">
															<img src="images\1.jpg" alt="">
															<div class="info d-flex align-items-center p-md-3 p-2 bg-primary">
																<svg class="mr-3 d-sm-inline-block d-none" width="30" height="30"
																	viewBox="0 0 30 30" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																		d="M28.75 12.5C28.7538 11.8116 28.568 11.1355 28.213 10.5458C27.8581 9.95597 27.3476 9.47527 26.7376 9.15632C26.1276 8.83737 25.4415 8.69248 24.7547 8.73752C24.0678 8.78257 23.4065 9.01581 22.8434 9.4117C22.2803 9.80758 21.837 10.3508 21.5621 10.9819C21.2872 11.613 21.1913 12.3076 21.2849 12.9896C21.3785 13.6715 21.6581 14.3146 22.0929 14.8482C22.5277 15.3819 23.101 15.7855 23.75 16.015V20C23.75 21.6576 23.0915 23.2473 21.9194 24.4194C20.7473 25.5915 19.1576 26.25 17.5 26.25C15.8424 26.25 14.2527 25.5915 13.0806 24.4194C11.9085 23.2473 11.25 21.6576 11.25 20V18.65C13.3301 18.3482 15.2323 17.3083 16.6092 15.7203C17.9861 14.1322 18.746 12.1019 18.75 10V2.5C18.75 2.16848 18.6183 1.85054 18.3839 1.61612C18.1495 1.3817 17.8315 1.25 17.5 1.25H13.75C13.4185 1.25 13.1005 1.3817 12.8661 1.61612C12.6317 1.85054 12.5 2.16848 12.5 2.5C12.5 2.83152 12.6317 3.14946 12.8661 3.38388C13.1005 3.6183 13.4185 3.75 13.75 3.75H16.25V10C16.25 11.6576 15.5915 13.2473 14.4194 14.4194C13.2473 15.5915 11.6576 16.25 10 16.25C8.34239 16.25 6.75268 15.5915 5.58058 14.4194C4.40848 13.2473 3.75 11.6576 3.75 10V3.75H6.25C6.58152 3.75 6.89946 3.6183 7.13388 3.38388C7.3683 3.14946 7.5 2.83152 7.5 2.5C7.5 2.16848 7.3683 1.85054 7.13388 1.61612C6.89946 1.3817 6.58152 1.25 6.25 1.25H2.5C2.16848 1.25 1.85054 1.3817 1.61612 1.61612C1.3817 1.85054 1.25 2.16848 1.25 2.5V10C1.25402 12.1019 2.01386 14.1322 3.3908 15.7203C4.76773 17.3083 6.6699 18.3482 8.75 18.65V20C8.75 22.3206 9.67187 24.5462 11.3128 26.1872C12.9538 27.8281 15.1794 28.75 17.5 28.75C19.8206 28.75 22.0462 27.8281 23.6872 26.1872C25.3281 24.5462 26.25 22.3206 26.25 20V16.015C26.9792 15.7599 27.6114 15.2848 28.0591 14.6552C28.5069 14.0256 28.7483 13.2726 28.75 12.5Z"
																		fill="white" />
																</svg>
															</div>
														</div>
														<div class="card-info d-flex align-items-start">
															<div class="mr-auto pr-3">
																<h2 class="font-w600 mb-2 text-black">
																	<?php echo $row['fullName']; ?>
																</h2>

																<p class="mb-2">Symptom:
																	<?php
																	$sql_patient_symptom = "SELECT * FROM symptom WHERE patientId = " . $patient_id;
																	$result_patient_symptom = mysqli_query($conn1, $sql_patient_symptom);
																	if (mysqli_num_rows($result_patient_symptom) > 0) {
																		$num = mysqli_num_rows($result_patient_symptom);
																		$i = 0;
																		while ($row_patient_symptom = mysqli_fetch_assoc($result_patient_symptom)) {
																			echo $row_patient_symptom['symptomsName'];
																			$i++;
																			if ($num > $i) {
																				echo ", ";
																			}
																		}
																	}
																	?>
																</p>

																<p class="mb-2">Comorbidity:
																	<?php
																	$sql_patient_comorbidity = "SELECT * FROM comorbidities WHERE patientID = " . $patient_id;
																	$result_patient_comorbidity = mysqli_query($conn1, $sql_patient_comorbidity);
																	if (mysqli_num_rows($result_patient_comorbidity) > 0) {
																		$num = mysqli_num_rows($result_patient_comorbidity);
																		$i = 0;
																		while ($row_patient_comorbidity = mysqli_fetch_assoc($result_patient_comorbidity)) {
																			echo $row_patient_comorbidity['comorbidityName'];
																			$i++;
																			if ($num > $i) {
																				echo ", ";
																			}
																		}
																	}
																	?>
																</p>
															</div>
															<span class="mr-ico bg-primary">
																<i class="las la-mars"></i>
															</span>
														</div>
													</div>
													<h4 class="fs-20 text-black font-w600">Story About Disease</h4>
													<p>
														My experiences, along with the combined testimonies of trans and rare
														disease patients around the world, prove a throughline within medicine that
														I believe is getting in the way of a healthier experience for everyone: that
														medical professionals are too often on auto-pilot, looking for horses when
														faced with zebras, and not willing enough to learn from their patients’
														self-reported experiences. I would go as far as to add that those with the
														specialized knowledge necessary to diagnose rare diseases are seemingly even
														less likely to have an up-to-date education on bedside manner that is
														inclusive of trans and gender-nonconforming people.
													</p>

												</div>
											</div>
										</div>
										<div class="col-lg-7">
											<div class="card">
												<div class="card-body">
													<div class="row">
														<div class="col-sm-7 mb-sm-0 mb-3">
															<div class="d-flex">
																<i class="las la-map-marker text-primary fs-34 mr-3"></i>
																<div>
																	<span class="d-block mb-1">Address</span>
																	<p class="fs-18 mb-0 text-black">
																		<?php echo $row['address'] ?><strong class="d-block">CADGE
																			94107</strong>
																	</p>
																</div>
															</div>
														</div>
														<!-- <div class="col-sm-5">
															<div class="map-bx">
																<img src="images/map.jpg" alt="">
																<a href="javascript:void(0)"
																	class="btn btn-sm btn-primary p-1 fs-12">View in Fullscreen</a>
																<i class="las la-map-marker"></i>
															</div>
														</div> -->
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-5">
											<div class="row">
												<div class="col-lg-12 col-sm-6">
													<div class="card">
														<div class="card-body">
															<div class="media align-items-center">
																<i class="las la-phone fs-30 text-primary mr-3"></i>
																<div class="media-body">
																	<span class="d-block mb-1">Phone</span>
																	<p class="fs-18 mb-0 text-black">
																		<?php echo $row['phone'] ?>
																	</p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-12 col-sm-6">
													<div class="card">
														<div class="card-body">
															<div class="media align-items-center">
																<i class="las la-envelope-open fs-30 text-primary mr-3"></i>
																<div class="media-body">
																	<span class="d-block mb-1">Email</span>
																	<p class="fs-18 mb-0 text-black">info@mail.com</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-xxl-12">
									<div class="row">
										<div class="col-xl-12 col-xxl-8 col-lg-7">
											<div class="card">
												<div class="card-header border-0 pb-0">
													<div>
														<h4 class="fs-20 text-black mb-1">Patient Statistic</h4>
														<span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
													</div>
												</div>
												<div class="card-body">
													<div class="row align-items-center">
														<div class="col-xl-12 col-xxl-6 col-sm-6">
															<div id="pieChart"></div>
														</div>
														<div class="mt-4 col-xl-12 col-xxl-6 col-sm-6">
															<div class="d-flex mb-3 align-items-center">
																<span class="fs-12 col-6 p-0 text-black">
																	<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19"
																		fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="19" height="19" fill="#5F74BF" />
																	</svg>
																	Immunities
																</span>
																<div class="progress rounded-0 col-6 p-0">
																	<div class="progress-bar rounded-0 progress-animated"
																		style="width: 80%; height:6px;background:#5F74BF;"
																		role="progressbar">
																		<span class="sr-only">60% Complete</span>
																	</div>
																</div>
															</div>
															<div class="d-flex mb-3 align-items-center">
																<span class="fs-12 col-6 p-0 text-black">
																	<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19"
																		fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="19" height="19" fill="#FFD439" />
																	</svg>
																	Stamina
																</span>
																<div class="progress rounded-0 col-6 p-0">
																	<div class="progress-bar rounded-0 progress-animated"
																		style="width: 40%; height:6px;background:#FFD439;"
																		role="progressbar">
																		<span class="sr-only">60% Complete</span>
																	</div>
																</div>
															</div>
															<div class="d-flex mb-3 align-items-center">
																<span class="fs-12 col-6 p-0 text-black">
																	<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19"
																		fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="19" height="19" fill="#FF6E5A" />
																	</svg>
																	Heart Beat
																</span>
																<div class="progress rounded-0 col-6 p-0">
																	<div class="progress-bar rounded-0 progress-animated"
																		style="width: 90%; height:6px;background:#FF6E5A;"
																		role="progressbar">
																		<span class="sr-only">60% Complete</span>
																	</div>
																</div>
															</div>
															<div class="d-flex align-items-center">
																<span class="fs-12 col-6 p-0 text-black">
																	<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19"
																		fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect width="19" height="19" fill="#5FBF91" />
																	</svg>
																	Colestrol
																</span>
																<div class="progress rounded-0 col-6 p-0">
																	<div class="progress-bar rounded-0 progress-animated"
																		style="width: 80%; height:6px;background:#5FBF91;"
																		role="progressbar">
																		<span class="sr-only">60% Complete</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-12">
											<div class="card">
												<div class="card-header border-0 pb-0">
													<h4 class="fs-20 text-black mb-0">Note for patient</h4>
													<a href="javascript:void(0)">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" clip-rule="evenodd"
																d="M20.8684 8.09625C20.9527 8.25375 21 8.43375 21 8.625V18.75C21 21.2351 18.9862 23.25 16.5 23.25H4.125C3.504 23.25 3 22.746 3 22.125V1.875C3 1.254 3.504 0.75 4.125 0.75H13.125C13.3162 0.75 13.4963 0.797251 13.6538 0.881626L13.6571 0.883874C13.7449 0.929999 13.827 0.989626 13.9013 1.0605L13.9204 1.07962L20.6704 7.82962L20.6895 7.84875C20.7615 7.92413 20.82 8.00625 20.8673 8.09287L20.8684 8.09625ZM12 3H5.25V21H16.5C17.7431 21 18.75 19.9931 18.75 18.75V9.75H13.125C12.504 9.75 12 9.246 12 8.625V3ZM9.75 18.75H14.25C14.871 18.75 15.375 18.246 15.375 17.625C15.375 17.004 14.871 16.5 14.25 16.5H9.75C9.129 16.5 8.625 17.004 8.625 17.625C8.625 18.246 9.129 18.75 9.75 18.75ZM8.625 14.25H15.375C15.996 14.25 16.5 13.746 16.5 13.125C16.5 12.504 15.996 12 15.375 12H8.625C8.004 12 7.5 12.504 7.5 13.125C7.5 13.746 8.004 14.25 8.625 14.25ZM17.1592 7.5L14.25 4.59075V7.5H17.1592Z"
																fill="black" />
														</svg>
													</a>
												</div>
												<div class="card-body pt-3">
													<p class="mb-0"></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- row -->

							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Testing</h4>

									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example4" class="display min-w850">
												<thead>
													<tr>
														<th>Test Number</th>
														<th>Patient</th>
														<th>Test Date</th>
														<th>Status</th>
														<th>PCR Test</th>
														<th>PCR Value</th>
														<th>Quick Test</th>
														<th>Quick Test Value</th>
														<th>SP02</th>
														<th>Respiratory rate</th>
													</tr>
												</thead>
												<?php
												$sql_test = "SELECT * FROM testing_information t
															INNER JOIN patient p ON p.patientID = t.patientID
															WHERE t.patientID = " . $patient_id;
												$result_test = mysqli_query($conn1, $sql_test);
												if (mysqli_num_rows($result_test) > 0) {
													$i = 1;
													while ($row_test = mysqli_fetch_assoc($result_test)) {
														?>
														<tbody>
															<tr>
																<td>
																	<?php echo $i++ ?>
																</td>
																<td>
																	<?php echo $row['fullName']; ?>
																</td>
																<td>
																	<?php echo $row_test['testTime'] ?>
																</td>

																<?php
																if ($row_test['SPO2_percentage'] < 96 && $row_test['Respiratory_rate'] > 20) {
																	?>
																	<td><span class="badge light badge-danger">Warning</span></td>
																	<?php
																} else if ($row_test['PCR_test_value'] > 30 || $row_test['quick_test_value'] > 30) {
																	?>
																		<td><span class="badge light badge-success">Discharge</span></td>
																	<?php
																} else {
																	?>
																		<td><span class="badge light badge-warning">Wait for test</span></td>
																	<?php
																}
																?>

																<td><span class="text-dark">
																		<?php echo $row_test['PCR_test_result'] == 1 ? "Positive" : "Negative"; ?>
																	</span></td>

																<td><span class="text-dark">
																		<?php echo $row_test['PCR_test_value'] == "" ? "None" : $row_test['PCR_test_value']  ?>
																	</span></td>

																<td><span class="text-dark">
																		<?php echo $row_test['quick_test_result'] == 1 ? "Positive" : "Negative"; ?>
																	</span></td>

																<td><span class="text-dark">
																		<?php echo $row_test['quick_test_value'] == "" ? "None" : $row_test['quick_test_value'] ?>
																	</span></td>

																<td><span class="text-dark">
																		<?php echo $row_test['SPO2_percentage']; ?>
																	</span></td>

																<td><span class="text-dark">
																		<?php echo $row_test['Respiratory_rate']; ?> bpm
																	</span></td>
															</tr>
														</tbody>
													<?php }
												} ?>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Treatment</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example4" class="display min-w850">
												<thead>
													<tr>
														<th>Doctor</th>
														<th>Patient</th>
														<!-- <th>Result</th> -->
														<th>Date Start</th>
														<th>Date End</th>
													</tr>
												</thead>
												<?php
												$sql_treatment = "SELECT * FROM `treatment`
																				INNER JOIN people ON treatment.DoctorID = people.peopleID
																				INNER JOIN patient ON `treatment`.`patientID` = `patient`.`patientID` WHERE treatment.patientID =" . $patient_id;
												$result_treatment = mysqli_query($conn1, $sql_treatment);
												if (mysqli_num_rows($result_treatment) > 0) {
													while ($row_treatment = mysqli_fetch_assoc($result_treatment)) {
														?>
														<tbody>
															<tr>
																<td><span class="text-nowrap">
																		<?php
																		switch ($row_treatment["role"]) {
																			case 'Doctor':
																				echo $row_treatment['peopleName'];
																				break;
																			case 'Nurse':
																				echo $row_treatment['peopleName'];
																				break;
																			case 'Staff':
																				echo $row_treatment['peopleName'];
																				break;
																			case 'Volunteer':
																				echo $row_treatment['peopleName'];
																				break;
																			case 'Manager':
																				echo $row_treatment['peopleName'];
																				break;
																		} ?>
																	</span></td>
																<td><span class="text-nowrap">
																		<?php echo $row_treatment['fullName']; ?>
																	</span></td>
																<!-- <td><span class="badge light badge-success">Recovered</span></td> -->
																<td>
																	<?php echo $row_treatment['admissionDate']; ?>
																</td>
																<td>
																	<?php if ($row_treatment['dischargeDate'] == "") {
																		echo "Unknown";
																	} else {
																		echo $row_treatment['dischargeDate'];
																	}
																	?>
																</td>
															</tr>
															<!-- <tr>
											<td><span class="text-nowrap">#B-00002</span></td>
											<td><span class="text-nowrap">#P-00007</span></td>
											<td><span class="badge light badge-warning">In Treatment</span></td>
											<td>07/06/2020</td>
											<td>28/02/2024</td>
										</tr> -->
														</tbody>
													<?php }
												} ?>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Location History</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example4" class="display min-w850">
												<thead>
													<tr>
														<th>Patient</th>
														<th>Date Start</th>
														<th>Date End</th>
														<th>Room</th>
													</tr>
												</thead>
												<?php
												$sql_location = "SELECT * FROM patient_location_history plh
												INNER JOIN patient ON plh.patientID = patient.patientID WHERE plh.patientID =" . $patient_id;
												$result_location = mysqli_query($conn1, $sql_location);
												if (mysqli_num_rows($result_location) > 0) {
													while ($row_location = mysqli_fetch_assoc($result_location)) {
														?>
														<tbody>
															<tr>
																
																<td><span class="text-nowrap">
																		<?php echo $row_location['fullName']; ?>
																	</span></td>
																<!-- <td><span class="badge light badge-success">Recovered</span></td> -->
																<td>
																	<?php echo $row_location['entryDateTime']; ?>
																</td>
																<td>
																	<?php if ($row_location['exitDateTime'] == "") {
																		echo "Unknown";
																	} else {
																		echo $row_location['exitDateTime'];
																	}
																	?>
																</td>
																<td>
																	<?php echo $row_location['roomNumber']; ?>
																</td>
															</tr>
															<!-- <tr>
											<td><span class="text-nowrap">#B-00002</span></td>
											<td><span class="text-nowrap">#P-00007</span></td>
											<td><span class="badge light badge-warning">In Treatment</span></td>
											<td>07/06/2020</td>
											<td>28/02/2024</td>
										</tr> -->
														</tbody>
													<?php }
												} ?>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--**********************************
			Content body end
		***********************************-->

				<!--**********************************
			Footer start
		***********************************-->
				<?php
		}
	} else {
		echo "0 result";
	}
}
function currency_format($number, $suffix = 'VNĐ')
{
	if (!empty($number)) {
		return number_format($number, 0, ',', '.') . "{$suffix}";
	}
}

include("includes/footer.php");

?>
	<!--**********************************
			Footer end
		***********************************-->

	<!--**********************************
		   Support ticket button start
		***********************************-->

	<!--**********************************
		   Support ticket button end
		***********************************-->


	</div>
	<!--**********************************
		Main wrapper end
	***********************************-->

	<!--**********************************
		Scripts
	***********************************-->
	<!-- Required vendors -->
	<script src="./vendor/global/global.min.js"></script>
	<script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="./js/custom.min.js"></script>
	<script src="./js/deznav-init.js"></script>

	<!-- Datatable -->
	<script src="./vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="./js/plugins-init/datatables.init.js"></script>
</body>

</html>