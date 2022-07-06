<?
    /*
     * UPUTA ZA PREVOĐENJE:
     * 
     * za prevođenje koristiti program Notepad++. Download link za windows: 
     * https://notepad-plus-plus.org/repository/7.x/7.2/npp.7.2.Installer.exe
     * 
     * za Linux koristiti gEdit - već je instaliran
     * 
     * Što prevoditi?
     * 
     * Lijeva strana do zareza se ne smije dirati. Prevodi se samo sadržaj u navodnicima iza zareza:
     * 
     * define("BOOM_WRONG", "<h1>Boooom!</h1>Something went wrong...");
     * |------ne dirati----||---------- prevesti -------------------|
     * 
     * Znakovi ograničeni sa <...> se NE DIRAJU i NE PREVODE. Primjer:
     * 
     * define("BOOM_WRONG", "<h1>Boooom!</h1>Something went wrong...");
     *                      |-NE|--da---|-NE|------ da -------------|NE DIRATI
     * 
     * Pojednostavljeno:
     * pisati prevedeni tekst preko originala, ništa osim jasno razumljivog engleskog ne dirati
     * 
     */


    define("SITE_NAME", 'jamtransfer.com');

    define("BACK_TO", 'Back to');
	define('PLEASE_SELECT','Please select...');
	define('LOADING', 'Loading...');
	define('STARTING_FROM','Starting from');
	define('GOING_TO', 'Going to');
	define("CONTACT_US", "Contact us");
	define("CONTACT", "Contact");
	define("BOOK_HERE_META", "Door-to-door taxi transfers - Very reasonable prices  - 5 vehicle types -  Cash payment option");

	define('START_HERE', 'Need a transfer?');
	define("BOOK_NOW", "Search");
	define("SEE_PRICES", "See prices");
	define("PRICES_STARTING_FROM", "Prices starting from");
	define("MORE_DETAILS", "Few more details...");
	define("CLICK_BACK", "Go back one step");
	define('PLEASE_FILL_IN_ALL_DATA', 'Please fill-in all the data and then press Vehicles button.');
	define('AGENTS_WARNING', 'IMPORTANT: please keep in mind that we need at least 
							  24 hours to organize a transfer successfully.<br>
							  For same day transfers contact us prior to booking to confirm availability!');
	define('COUNTRY', 'Country');
	define('FROM', 'From');
	define('TO', 'To');
	define('PICKUP_DATE', 'Pickup date');
	define('PICKUP_TIME', 'Pickup time');
	define("NOTES", "Notes");
	define("PICKUP_ADDRESS", "Pickup Address");
	define("DROPOFF_ADDRESS", "Drop-Off Address");
	define("AIRPORT", "Airport terminal");
	define('PASSENGERS_NO', 'Passengers');
	define('RETURN_TRANSFER', 'Return transfer');
	define('YES', 'Yes');
	define('NO', 'No');
	define('RETURN_DATE', 'Return date');
	define('RETURN_TIME', 'Return time');
	define('YOUR', 'Your');
	define('NAME', 'Name');
	define('EMAIL', 'E-mail');
	define('CITY', 'City');
	define('ADDRESS', 'Address');
	define('ZIP', 'ZIP');
	define("ABOUT_YOUR_TRANSFER", 'Transfer details');
	define("YOUR_CONTACT_INFO", 'Passenger info');
	define("EXTRAS", "Extras");
	define("TOTAL", "Total");
	define("GRAND_TOTAL", "You Pay");
	define('PASSWORD', 'Password');
	define('FORGOT_PASSWORD', 'Forgot your password?');
	define('MOBILE_NUMBER', 'Mobile number');
	define('LANGUAGE', 'Language');
	define('BTN_CONTINUE', 'Continue');
	define('CLICK_HERE', 'Click here');
	define('CREATE_PROFILE', 'Save my account');
	define("SUBSCRIBED", 'Subscribed');
	define("SUBSCRIBE", 'Subscribe');

	define("BOOKING_WIZZARD", 'Get a transfer!');
	define("BOOKING_INTRO", "
					Book your vehicle here in 3 simple steps.
			");
	define("ROUTE_INFO", '<strong>1 </strong> / 4');
	define("SELECT_CAR", 'Vehicles');
	define("VEHICLE_TYPE", "Vehicle Type");
	define("SELECTED_VEHICLE", "Selected Vehicle");
	define("GOTO_PAYMENT", "Secure Server Payment");
	define("RATINGS", "Ratings");
	define("NOTHING_FOUND", "It seems that no drivers are available for Your transfer.<br>Please check again later.<br><br>Thank You!");
	define("BASE_PRICE", 'Base price');
	define("NIGHT_PRICE", 'Night');
	define("OTHER_PRICES", 'Price correction');

	define("FREE_QUOTE", 'Get a Free Quote');
	define("TO_YOUR_INBOX", "directly to your Inbox");
	define("WE_RESPECT_PRIVACY", "We respect Your privacy.<br>You will never receive unwanted e-mails from us.");
	define("TELL_US_MORE", 'Tell us more about your trip');
	define("EMAIL_ME", 'Send me a Quote');
	define("CONTINUE_BOOKING", 'Continue with Booking');
	define("BOOK_THIS_VEHICLE", "<h4>Click to Book this car</h4>");
	define("YOUR_QUOTE", "You have requested a Quote for the taxi transfer with following details");
	define("AVAILABLE_VEHICLES", "Available vehicles");
	define("NOT_REAL_CAR", "*Images do not represent actual vehicles");
	define("CONTACT_FORM", "Send us a message");
	define("MESSAGE", "Message");
	define("VEHICLES_NO", "Vehicles");
	define("NOTE_DISCOUNTS", "
			Important: only base prices are shown here. Various discounts may apply!<br>
			Please enter the date and time of your transfer and click Vehicles button to see final prices.
	");

	define("LOG_IN", "Log in");
	define("SIGN_UP", "Sign up");
	define("USERNAME", 'User Name');
	define("USER_TYPE", 'Register As');
	define("CUSTOMER", 'Customer');
	define("DRIVER", 'Driver');
	define("AGENT", 'Agent');
	define("AFFILIATE", 'Affiliate Partner');
	define("WELCOME", 'Welcome');
	define("EDIT_PROFILE", 'Edit profile');
	define("DELETE_PROFILE", 'Delete profile');
	define("MY_TRANSFERS", "My transfers");

	define("AVAILABLE_AIRPORTS",'Your airport');

	define("PRICE", "Price");
	define("VEHICLE_NAME", "Vehicle name");
	define("VEHICLE_CAPACITY", "Max.passengers");
	define("DRIVER_NAME", "Driver name");
	define("PAYMENT", "Payment");
	define("COUPON", "Coupon code");
	define("APPLY_COUPON", "Apply");
	define("CASH_PAYMENT_DETAILS", "Cash payment verification");
	define("CARD_HOLDER_DETAILS", "Credit Card details");
	define("ENTER_PIN", "Enter your PIN and click Verify button:");
	define("ORR", 'or');
	define("VERIFY_PIN", "Verify");
	define("YOUR_PIN", "Your PIN");
	define("PIN_NOT_VERIFIED", "Wrong PIN.");
	define("PIN_VERIFIED", "PIN Verified. You may proceed.");
	define("SEND_PIN", "Send PIN");
	define("SEND_PIN_AGAIN", "Send new PIN");
	define("INVALID_MOBILE_NUMBER", "Invalid or missing Mobile number.");
	define("INVALID_EMAIL_ADDRESS", "Invalid or missing e-mail address.");
	define("PIN_SENT_TO", "PIN sent to");
	define("PAY_NOW", "Online");
	define("PAY_LATER", "Cash");
	define("PAY_INVOICE", "Invoice");
	define("PAYMENT_METHOD", "Payment method");
	define("PAY_CASH", "Cash only");
	define("PAY_ONLINE_CASH", "Online + Cash");
	define("PAY_ONLINE", "Full amount Online");
	define("FIRST_NAME", "First name");
	define("LAST_NAME", "Last name");
	define("YOU_MUST_ACCEPT", "You must accept our ");
	define("TERMS_AND_CONDITIONS", "Terms and Conditions");
	define("DECLINE", "Decline");
	define("ACCEPT", "Accept");
	define("SEND", "Submit");
	define("RETURN_AFTER_PAYMENT", "You will be returned here after payment.");
	define("CORRECT_ERRORS", "Errors are marked in red. Please correct errors and try again.");
	define("FLIGHT_NO", "Flight Number");
	define("FLIGHT_TIME", "Flight Time");
	define("ARRIVAL", "Arrival Flight Time");
	define("DEPARTURE", "Departure Flight Time");
	define("MOBILE_INSTRUCTIONS", '
			For <strong>Cash only payments</strong> we have to verify your identity.<br>
			Click <strong>Send PIN</strong> 
			button to receive a text message with your PIN.<br>
			Message will be sent to the Mobile number entered <strong>above</strong>.<br>	
	');
	define("EMAIL_INSTRUCTIONS", '
			For <strong>Cash only payments</strong> we have to verify your identity.<br>
			Click <strong>Send PIN</strong> 
			button to receive an e-mail message with your PIN.<br>
			Message will be sent to the e-mail address entered <strong>above</strong>.<br>	
	');

	define("COUNTRIES_TITLE", "Taxi transfers");
	define("COUNTRIES_SLOGAN", "We have almost all European countries covered");
	
	define("THANK_YOU", "Thank you");
	
	define("ROUTE_NOT_FOUND", "Sorry, Route not found");
	define("CHECK_FROM_TO", 'Please review your From and To locations.');
	define("NO_DRIVERS", 'Sorry, no drivers');
	define("NO_DRIVERS_EXT", 'It seems there are no active drivers for this Route');
	define("NO_VEHICLES", 'Please <a href="http://www.jamtransfer.com/contact">Contact us</a> for latest prices!');
	define("NO_VEHICLES_EXT", 'No vehicles seem to be available for this Route.');
	define("TOO_SMALL", 'No large enough vehicle.');
	define("AVAILABILITY_DEPENDS", "Availability and final prices depend on Date and Time of Your transfer.");
	define("FILL_PICKUP_PRESS_SHOW", "Please fill-in Pickup Date and Pickup Time and click Show Vehicles button to get full prices");
	
	
	define("SPECIAL_OFFERS", "Special Offers");
	
	define("SERVICES_DESC1", "
		Service includes vehicle and driver
	");

	define("SERVICES_DESC2", "
		Prices are per vehicle, not per person
	");
	
	define("SERVICES_DESC5", "
		One piece of medium luggage and one piece of hand luggage per passenger are free of charge
	");
	
	define("SERVICES_DESC6", "
		We will send you driver`s contact information by email
	");
	
	define("SERVICES_DESC7", "
			Your driver will meet you with the nameplate at the pick up point. Keep your phone turned on
	");
	
	define("SERVICES_DESC3", "
			Waiting at the airports up to one hour after landing time is free 
	");

	define("SERVICES_DESC4", "
			 Flight delays are monitored
	");
	
	define("SERVICES_DESC8", "
			 In case of delay, cancellation or other unforeseen circumstances, 
			 you are obligated to inform your driver (local operator) or in case 
			 of emergency our Call Centre +381646597200
	");
	
	define("SERVICES_DESC9", "
			In case that you have not received driver's contact 
			information by e-mail 24 hours before the transfer, please contact us.
	");
			
	
	define("ACCEPTED_TERMS", "
		You have accepted our Terms and Conditions, Privacy policy and Refund policy<br>
		<small>Note: Transportation to the islands is organized in a way that one vehicle drives 
		you from the starting point of transfer to the ship. You board the ship without a vehicle, 
		just passengers and baggage. On the island, another vehicle will expect you and take you 
		from the ship to the final destination. 
		The specified price includes the cost of both transfers and ship fare.</small>
	");
	
	define("PRINT_VOUCHER", "Print");
	define("TRANSFER_INFO", "Transfer Info");

// Widget
	
	define("BOOKING_SUCCESS", "
			You have successfully booked your transfer.	<br>
			Please check your Inbox for your e-mail Confirmation.<br>
			Be sure to check your Spam folder too.<br>
			<br>
			You can always print another copy from your Profile page<br>
			or you can just show the e-mail to your driver.<br>	
	");
	
	define("NO_REFRESH", "
			<h3>Please do not Refresh this page</h3><br>
			You have already booked your transfer.	<br>
			Please check your Inbox for your e-mail Confirmation.<br>
			Be sure to check your Spam folder too.<br>
			<br>
			You can always print another copy from your Profile page<br>
			or you can just show the e-mail to your driver.<br>	
	");
	
	define("TEMPORARY_RESERVATION", "THIS RESERVATION IS NOT VALID UNTIL CONFIRMED!");
	
	define("BOOKING_SUCCESS_WIDGET", "
			You have successfully created a Temporary Order.	<br>
			Your order will become valid once it is confirmed both by You and our staff.<br>
			Please check your Inbox for our e-mail and Confirm Your order.<br>
			Be sure to check your Spam folder too.<br>
			<br>
	");
	
	define("NO_REFRESH_WIDGET", "
			<h3>Please do not Refresh this page</h3><br>
			You have already created a Temporary Order.	<br>
			Please check your Inbox for your e-mail Confirmation.<br>
			Be sure to check your Spam folder too.<br>
			<br>
	");	
	
	define("VERIFICATION_REQUEST", 'Verification request');
	define("HELLO", "Hello");
	define("EMAIL_USED", 'Your e-mail address was used to make this Request for a taxi transfer.');
	define("WE_HAVE_TO", 'We have to verify Your identity, so we can complete Your order.');
	define("NOT_ME", "If it wasn't You, please reply using words - Not me - in Subject or Message body.");
	define("IMPORTANT", "Important");
	define("ORDER_NOT_VALID", 'This Order is NOT valid until it is confirmed both by You and our staff.');
	define("YOU_HAVE_TO_CONFIRM", 'You have to <strong>Confirm</strong> Your order by clicking on the button below:');
	define("CONFIRM_MY_ORDER", "Confirm my order");
	define("CANCEL_MY_ORDER", "Cancel my order");
	define("AFTER_CONFIRMATION", "
			After Your Confirmation is received, <br>
			our staff will create a valid Reservation for You <br>
			and You will receive another e-mail with Your <strong>Booking Voucher</strong>.
			");
	define("FEEDBACK", "
			We are doing our best to accommodate our customers, so if You have any suggestions,<br>
			we would greatly appreciate Your feedback. <br><br>
	");
	define("THIS_SITE", "This web site");
	define("AUTHORIZED_PARTNER", "is an Authorized Partner of jamtransfer.com");
	define("NO_SPAM", "
			This e-mail was sent to You on Your request and it is not a spam. <br>
			Your e-mail address is not added to any mailing lists and there won't be any messages from us, 
			unless they are required to complete Your transfer. <br>
			If You cancel this order, Your personal info will be deleted permanently. <br>
	");
	
	define("REMINDER_TEXT", '
		Thank you for visiting our web site.
		<br><br>
		We noticed that you didn\'t confirm your order. Can we do anything to help?
		<br>
		You can go  the "Confirm my order " button below.
		<br>
		We never charge booking fees, and we guarantee the best price for 
		<br>
		every transfer so that you get the lowest price every time.
	');
	
	define("UNDEFINED_ERROR", "There was an error");
	define("SOMETHING_WRONG", "
			<h4>Sorry, something went wrong. Your order was lost.</h4>
			Please let us know if You see this error so we can fix it.<br>
			Thank You!
	");
	define("PAYMENT_ERROR", "Payment error");
	define("PAYMENT_ERROR_TEXT","
			Your payment was not successful. <br><br>Please click <a href='http://".$_SERVER['SERVER_NAME']."/contact'>here</a> to contact us.
	");
	
	// DRIVER MESSAGE
	define("ORDER_CONFIRMATION", "Confirmation for ");
	define("NEW_TRANSFER", "New transfer");
	define("TRANSFER_FOR_YOU","
			We have new transfers for you.<br>
			Please Confirm or Decline these transfers immediately using the link(s) below:<br><br>
	");
	define("THIS_INFO_WILL_BE_SENT_TO_CUSTOMER", "Please fill-in the following data.This info will be sent to customer.");
	
	define("TRANSFER_UPDATE", "Update for transfer ");
	
	// CANCEL ORDER - by Passenger
	define("HERE_IS_YOUR_ORDER", "Here is Your Order");
	define("NO_ORDER", "this Order does not exist in our system.");
	define("NO_UNDO", "Important: Cancel operation can not be un-done.");
	define("ORDER_CANCELLED", "Your Order is cancelled.");
	define("CLOSE_WINDOW","You can close this window now.");
	define("ALREADY_CANCELLED", "Your have already cancelled your order.");
	define("ALREADY_CONFIRMED", "Your have already confirmed your order.");

	// INDEX.php
	define("SIGN_IN", "Sign in");
	define("USERNAME_EMAIL", "User name or E-mail");
	define("NOSCRIPT", "Javascript MUST be enabled if you want to make a booking!");
	define("ABOUT_US", "About Us");
	define("ABOUT_JAM", "jamtransfer.com is part of J.A.M. Group, a Croatian company with branches throughout Europe. Since 2006. we have provided taxi transfer service to over 500 000 clients.");
	define("READ_MORE", "Read more");
	define("SEARCH", "Search");
	define("COUNTRIES", "Countries");
	define("AIRPORTS", "Airports");
	define("LEGAL", "Legal");
	define("PRIVACY_POLICY", "Privacy Policy");
	define("COOKIE_POLICY", "Cookie Policy");
	define("CONNECT", "Connect");
	define("AGENT_LOGIN", "Agent Login");

	// PARA_ABOUT_US.php
	define("TV_REPORT", "TV-report");
	define("TV_ABOUT1", "This is a slightly shortened version of a TV-report about jamtransfer.com and a poll on buying tourist services online. Split Airport 2010.");
	define("TV_ABOUT2", "All participants are real people in real life situations.<br><br>Published with permission.");
	define("UNDER_CONSTRUCTION", "Page is under construction");

	// PARA_BACK.html
	define("HOME", "Home");
	define("SUPPORT_ORDERS", "SUPPORT & ORDERS");
	define("CALL_CENTER", "Call center");

	// PARA_BOOKING.php
	define("FAQQ1", "Where will I meet the driver when I arrive?");
	define("FAQA1", "All our transfer services include Meet &amp; Greet service. Therefore the driver will be waiting for you at the arrivals with a sign showing your name. In case you experience difficulties in locating the driver you can always call our customer support, which will arrange the meeting immediately.");
	define("FAQQ2", "Will I be dropped off at my accomodation?");
	define("FAQA2", "Yes, all our services are door-to-door. The driver will take you directly to the address you gave us during the booking.");
	define("FAQQ3", "What if my flight is delayed?");
	define("FAQA3", "All flights are monitored for delays to ensure your driver will be waiting for you when you arrive. There are no extra charges if your flight is delayed.");
	define("FAQQ4", "Are there any additional fees or hidden costs?");
	define("FAQA4", "No, there are no booking fees and all our prices are all-inclusive (incl. VAT).");
	define("FAQQ5", "Will anyone else be travelling in the vehicle I book?");
	define("FAQA5", "No, we only offer private transfer services, the price you pay reserves the vehicle exclusively for you.");
	define("BOOKING_ABOUT_1", "<strong>Why is the Taxi Transfer Service from ");
	define("BOOKING_ABOUT_2", " to ");
	define("BOOKING_ABOUT_3", " the easiest way of transportation ?</strong><br><br>From the moment you contact us, we’ll do everything we can to ensure that your booking and transfer go as smoothly as possible. An experienced driver with proven customer service skills and an extensive knowledge of the local area will meet you in an air conditioned vehicle tailored to the number of passengers and the luggage requirements specified by you.<br><br><b>Airport Shuttle Service</b> - We will pick you up at ");
	define("BOOKING_ABOUT_4", ".If Your arrival is delayed, Your driver will be waiting, without any additional costs.<br>Once you reach <b>");
	define("BOOKING_ABOUT_5", "</b> in a comfortable, air conditioned vehicle, you will feel much better than going through all the hassle using public transportation.<br>Did we mention that our prices for transfers to and from <b>");
	define("BOOKING_ABOUT_6", "</b> are the best?<br><br><b>Mini Van or Mini Bus Taxi Service</b> - if you travel to <b>");
	define("BOOKING_ABOUT_7", "</b> with a lot of luggage, or with a larger group, please select a mini van or a mini bus to take you to <b>");
	define("BOOKING_ABOUT_8", "</b>. Our mini vans and mini buses are very comfortable, air conditioned and suitable for larger groups or families. Children travel in a child seats and count as an adult!<br><br>Book Your Airport Taxi Transfer from <b>");
	define("BOOKING_ABOUT_9", "</b> to <b>");
	define("BOOKING_ABOUT_10", "</b> in advance. This way You will get the best service available.<br><br>");
	define("YOUR_TERM", "your starting point");
	define("YOUR_DEST", "your destination");

	// PARA_COUNTRIES.php
	define("START_TYPING", "Start typing the name...");

	// PARA_HOME.php
	define("TRY_TAXI_SERVICE", "Try our taxi transfer service!");

	// PARAHOMEQUOTEFORM.php
	define("RECEIVE_QUOTE", "only if you wish to receive a quote via e-mail");

	// HOWITWORKS.php
	define("HOW_WORKS", "How does it work");
	define("HW1", "Select your pickup and drop-off point, date and time and your vehicle  using the options below.");
	define("HW2", "Enter your personal details, select payment method and complete your payment on the <em>Final step</em> screen. Print your e-mail confirmation.");
	define("HW3", "Our driver will pick you up at the given time and place. Show your confirmation to your driver. It is your ticket.");
	define("HWB1", "Select your pickup and drop-off point, date and time and your car.");
	define("HWB2", "Verify the booking details and select your preferred payment method.");
	define("HWB3", "Our driver picks you up at the given location and time.");

	// PARA_LOGOUT.php
	define("LOGGED_OUT", "You are now logged out.");

	// PARA_ICONSECTION.php
	define("ICONS1", "No cancellation fee");
	define("ICONS2", "Meet and Greet service");
	define("ICONS3", "365/24/7 Support");
	define("ICONS4", "Flight monitoring");
	define("ICONS5", "We wait for you");
	define("ICONS6", "All-inclusive service");

	// PARA_SELECTCAR.php
	define("SSELECT", "Select");
	define("BEST_OFFER", "Best offer!");
	define("SMALL_VEHICLE", "Vehicle is too small.");
	define("BEST_PRICE", "Best price guarantee");
	define("NO_ADD_CHARGE", "No additional charges");
	define("DRIVERS_PROFILES", "Driver's Profiles");
	define("CLICK_PANEL", "click or tap panel to toggle details");

	// WIDGET
	define("WHERE_PICKUP", "Where do we pick you up?");
	define("WHERE_DROPOFF", "Where do we drop you off?");
	define("YOUR_FLIGHT_NO", "Your flight number");
	define("YOUR_FLIGHT_TIME", "Your flight time");
	define("YOUR_FIRST_NAME", "Your first name");
	define("YOUR_LAST_NAME", "Your last name");
	define("YOUR_EMAIL", "Your full email address");
	define("YOUR_TEL", "+Country Code - Area Code - Phone Number");
	define("PLEASE_READ", "T&C please read");
	define("BOOM_WRONG", "<h1>Boooom!</h1>Something went wrong...");
	define("CLICK_TO_BOOK", "click or tap panel to book the car");
	define("PRICES_DEPEND", "prices depend on Date and Time of the transfer");
	define("PRIVATE_TRANSFER", "This is a private transfer");
	define("EACH_PASSANGER", "Each passenger is allowed 2 pcs of luggage");

	// AGENT
	define("POWERED BY", "Powered by");
	define("RESERVATION_CODE", "Reservation Code");

	// f.php
	define("NO_COMPANY_DATA", "No company data");
	define("RESERVATION_CODE", "Reservation Code");
	define("TRANSFER_ID", "Transfer ID");
	define("TRANSFER_MISSING", "Transfer ID corrupt or missing.");
	define("TRANSFER_NOT_FOUND", "Transfer not found");

	// Coupon
	define("COUPON_APPLIED", "Coupon Applied.");
	define("COUPON_NOT_VALID", "Coupon not valid or expired!");

	// t/para_vehicle_classes.php - neaktivno
	define("VEHICLE_CLASSES", "Vehicle Classes");
	define("VC_1", "Standard");
	define("VC_2", "Premium");
	define("VC_3", "First Class");
	define("VC_CATEGORY_1", "Vehicle");
	define("VC_CATEGORY_2", "Equipment");
	define("VC_CATEGORY_3", "Driver");
	define("VC_CATEGORY_4", "Services");
	define("VC_1_1_1", "up to 9 years old vehicles");
	define("VC_2_1_1", "up to 4 years old vehicles");
	define("VC_3_1_1", "up to 2 years old vehicles");
	define("VC_1_1_2", "any vehicle model");
	define("VC_2_1_2", "middle/high class vehicle model");
	define("VC_3_1_2", "high class vehicle model");
	define("VC_1_1_3", "clean & safe");
	define("VC_1_2_1", "air condition");
	define("VC_1_2_2", "audio");
	define("VC_1_2_3", "leather seats");
	define("VC_1_2_4", "free WiFi");
	define("VC_1_3_1", "neat & polite");
	define("VC_1_3_2", "English speaking");
	define("VC_3_3_3", "suite & tie");
	define("VC_1_4_1", "meet & greet");
	define("VC_1_4_2", "help with luggage");
	define("VC_1_4_3", "music on client's request");
	define("VC_3_4_4", "bottled water");
	define("VC_3_4_5", "snacks/chocolates/candies");
	define("VC_3_4_6", "daily news or magazines in English");
	define("VC_3_4_7", "WiFi usage");
	define("VC_3_4_8", "umbrella in case of rain or snow");

	define("FREE_WIFI", "Free WiFi Onboard");
	define("SSELECT_2", "Select Car");
	define("SERVICES_DESC2_2", "Prices are per vehicle,<br>not per person");
	define("MORE", "more");
	define("LESS", "less");

