<?
	define("B", ' ');
	
/*	
	# TransferStatus taxido - trenutni
	$StatusDescription = array(
		'1' =>    'New',	// brise se
		'2' =>    'Active', 
		'3' =>    'Canceled', 
		'4' =>    'Refunded', // u PaymentStatus
		'5' =>    'No-Show', // u DriverConfStatus
		'6' =>    'DriverError', // u DriverConfStatus
		'7' =>    'Completed',
		'8' =>    'Comm.Paid'
	);
*/

	# Payment Status
	/* prva ideja
	$PaymentStatus = array(
		'0'	=>	'Not Paid',
		'1'	=>	'Paid Full Online',
		'2'	=>	'Paid Full Cash',
		'3'	=> 	'Paid Online Part',
		'4'	=> 	'Paid Cash Part',
		'5'	=>	'Invoice sent - Not paid',
		'6'	=>	'Invoice Paid',
		'7'	=>	'Warning sent',
		'8'	=> 	'Paid after Warning',
		'9'	=>	'Compensated',
		'10'=>	'Sued',
		'98'=>	'Paid - Closed',
		'99'=>	'Lost - will not be paid'
	);
	*/

	# TransferStatus - novi
	$StatusDescription = array(
		'1' =>    'Active',
		'2' =>    'Changed',
		'3' =>    'Canceled',
		'4' =>    'TEMP',
		'5'	=>	  'Completed',
		'6'	=>	  'PreOrder'
	);

	# Change Transfer Reason Method
	$ChangeTransferReason = array(
		'1'	=>	'Pax FirstLast Name',
		'2'	=>	'Pax Phone',
		'3'	=>	'Pax Email',
		'4'	=>	'Pickup Date',
		'5'	=>	'Pickup Time',
		'6'	=>	'Flight Time',
		'7'	=>	'Flight Number',		
		'8'	=>	'Pickup Address',
		'9'	=>	'Drop-Off Address',
		'10'	=>	'Pax Number',
		'11'	=>	'Payment method',
		'12'	=>	'Drivers Price',
		'13'	=>	'Extras',
		'14'	=>	'Pickup Notes',
		'15'	=>	'Message'
	);


	# Payment Method
	$PaymentMethod = array(
		'1'	=>	'Online',
		'2'	=>	'Cash',
		'3'	=>	'Combined',
		'4'	=>	'Bank transfer',
		'5'	=>	'Compensation',
		'6'	=>	'Bank transfer 2', 
		'9'	=>  'Other'
	);
	
	# Payment Method
	$AcceptedPayment = array(
		'0'		=>	'Not selected',
		'1'		=>	'All',
		'2'		=>	'Online',
		'3'		=>	'Cash',
		'10'	=>	'Invoice',
		'11'	=>	'Online',
		'12'	=>	'Invoice 2',
		'13'	=>	'Cash'
	);
	
	$PaymentStatus = array(
		'0'	=>	'Not Paid',
		'1'	=>	'Warning sent',
		'2' =>	'Sued',
		'3' =>  'Refunded',
		'10'=>	'Lost - will not be paid',
		'91'=>	'Compensated',
		'99'=>	'Paid'
	);	
	
	# DriverConfStatus
	$DriverConfStatus = array(
		'0'	=> 'No Driver',
		'1'	=> 'Not Confirmed',
		'2'	=> 'Driver Confirmed',
		'3' => 'Driver Assigned',
		'4'	=> 'Driver Declined',
		'5'	=> 'No-Show',
		'6' => 'Driver Error',
		'7' => 'Transfer Completed',		
		'8' => 'Operator Error',	
		'9' => 'Dispatcher Error',	
		'10' => 'Agent Error',			
	); 
	
	# Driver Payment
	$DriverPayment = array(
		'0' => 'Not Paid',
		'1' => 'Partly paid',
		'2'	=> 'Paid',
		'3' => 'Compensated'
	);
	
	# Transfers Filters
	$transfersFilters = array(
		array ("id" => "noDriver", "name" => "No Driver"), 
		array ("id" => "notConfirmed", "name" => "Not Confirmed"), 
		array ("id" => "confirmed", "name" => "Confirmed"), 
		array ("id" => "declined", "name" => "Declined"), 
		array ("id" => "canceled", "name" => "Canceled"), 
		array ("id" => "noShow", "name" => "No Show"), 
		array ("id" => "driverError", "name" => "Driver Error"), 
		array ("id" => "agent", "name" => "Agent transfers"), 
		array ("id" => "notConfirmedAgent", "name" => "Agent transfers Not Confirmed"), 
		array ("id" => "notComplited", "name" => "Not Complited"), 
		array ("id" => "invoice2", "name" => "Invoice 2"), 
	) ;	
	
	$monthNames = array("January", "February", "March", "April", "May", "June", "July",
	"August", "September", "October", "November", "December");

	$dayNames = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

define("ACCEPTED_PAYMENT", "Accepted Payment");
define("ACTIONS", "Actions");
define("ACTIVE", "Active");
define("ADD", "Add");
define("ADDRESS", "Address");
define("ADMIN", "Admin");
define("ADMIN_NOTES", "Staff Notes");
define("ADVANCED_SEARCH", "Advanced Search");
define("AFFILIATE", "Affiliate");
define("AGENT", "Agent");
define("AGENT_COMMISION", "Ag.Comm.");
define("AGENTS", "Agent orders");
define("ALL", "All");
define("ALL_DRIVERS", "All Drivers");
define("ALL_TRANSFERS", "All Transfers");
define("APIUSER", "API User");
define("APPROVED", "Approved");
define("ARTICLE", "Article");
define("ARTICLES", "Articles");
define("ASCENDING", "Ascending");
define("ASSIGNED_TO_ANOTHER_DRIVER", "This Transfer is assigned to another driver and removed from Your transfers list.");
define("BALANCE", "Balance");
define("BASE_PRICE", "Base Price");
define("BOOKED_BY", "Booked by");
define("BOOKING", "Booking");
define("BOOKINGS", "Bookings");
define("BRAND_NAME", "Brand name");
define("BY_BOOKING_DATE", "by booking date");
define("BY_TRANSFER_DATE", "by transfer date");
define("CALENDAR", "Calendar");
define("CANCELED_ORDERS", "Cancelled orders");
define("CANCELLED", "Cancelled");
define("CANCEL_TRANSFER", "Cancel transfer");
define("CASH", "Cash");
define("CLOSE", "Close");
define("COMPANY_ADDRESS", "Company address");
define("COMPANY_DESC", "Company description");
define("COMPANY_INFO", "Company Info");
define("COMPANY_NAME", "Company name");
define("COMPANY_TEXTS", "Various articles");
define("COMPANY_WEB", "Company web");
define("COMPLETED", "Completed");
define("CONFIRMED", "Ready");
define("CONTACT_PERSON", "Contact person");
define("CONTENT", "Content");
define("CONTRACT_FILE", "Contract file");
define("CONTRACT_DATE", "Contract date");
define("CONTRACT_SIGNATURE", "Contract signature");
define("COUNTRIES", "Countries");
define("COUNTRY_CURRENCY", "Country currency");
define("COUNTRY_NAME", "Country name");
define("COUNTRY_NAME_RU", "Country name in Russian");
define("COUPONS", "Coupons");
define("COUPON_DISCOUNT", "Coupon discount");
define("CURRENCY", 'Eur');
define("CURRENCYTYPE", 'Currency');
define("CURRENT_PRICE", "Active Price");
define("CUSTOM", "Custom");
define("CUSTOMER", "Customer");
define("DASHBOARD", "Dashboard");
define("DATE", "Date");
define("DATE_ADDED", "Date added");
define("DATA", "data");
define("DATA_CHECKED", "Data checked");
define("DATE_SETTINGS", "Off-Duty Dates");
define("DAY_SETTINGS", "Days of the week");
define("DECLINED", "Declined");
define("DELETE_COUNTRY", "Delete Country");
define("DELETE", "Delete");
define("DELETE_CACHE", "Delete cache");
define("DELETE_IMAGE", "Delete image");
define("DELETE_TRANSFER", "Delete transfer");
define("DELETE_USER", "Delete User");
define("DESCENDING", "Descending");
define("DETAIL_DESCRIPTION", "Please enter detailed description");
define("DISCOUNT", "Return Discount");
define("DISPLAY_ALL", "Display all");
define("DISPLAY_NOT_CHECKED", "Display not checked");
define("DRIVER", "Driver");
define("DRIVER_EMAIL", "Driver's Email");
define("DRIVER_ERROR", "Driver Error");
define("DRIVER_NAME", "Driver's Name");
define("DRIVER_PAID_AMOUNT", "Amount");
define("DRIVER_PAYMENT", "Driver Payment");
define("DRIVERS_BALANCE", "Driver's Balance");
define("DRIVERS_WITH_TRANSFERS", "Drivers with transfers");
define("DRIVERS_PRICE", "Driver's Price");
define("DRIVER_ROUTES", "Driver Routes");
define("DRIVERS", "Drivers");
define("DRIVER_STATUS", "Transfer status");
define("DRIVER_TEL", "Driver's Tel");
define("DROPOFF_ADDRESS", "Drop-Off Address");
define("DROPOFF_NAME", "Drop-Off Name");
define("DURATION", "Duration");
define("EDIT", "Edit");
define("EMAIL", "E-mail");
define("EMAIL_TO", "E-mail to");
define("EMERGENCY_PHONE", "Emergency phone");
define("EXTRAS", "Extra services");
define("FACEBOOK", "Facebook");
define("FINDER", "Finder");
define("FLIGHT_NO", "Flight Number");
define("FLIGHT_TIME", "Flight Time");
define("FREEFORM", "Free form transfer");
define("FRIAMOUNT", "Fri (amt)");
define("FRIPERCENT", "Fri (%)");
define("FROM", "From");
define("GOOGLE_PLUS", "Google+");
define("GRAPH", "Graph");
define("HEADER_IMAGES", "Header Images");
define("HELLO", "Hello");
define("ID", "ID");
define("IMAGE", "Image");
define("IMAGE_MANAGER", "Image manager");
define("ISLAND", "On island");
define("KEY", "Key");
define("LANGUAGE", "Language");
define("LASTCHANGE", "Last Change");
define("LAST_VISIT", "Last visit");
define("LEVEL", "Level");
define("LINKEDIN", "LinkedIn");
define("LIST", "List");
define("LOADING", "Loading...");
define("LOCATION", "Location");
define("LOCATIONS", "Locations");
define("LOCATION_TYPES", "Location Types");
define("LOGIN_FAILED", "Login failed!");
define("MARK_ACTIVE", "Mark Active");
define("MARK_COMPLETED", "Mark Completed");
define("MARK_NOSHOW", "No-Show");
define("MARK_ERROR", "Errors");
define("MARK_DRIVER_ERROR", "Driver Error");
define("MARK_OPERATOR_ERROR", "Operator Error");
define("MARK_DISPATCHER_ERROR", "Dispatcher Error");
define("MARK_AGENT_ERROR", "Agent Error");
define("MARK_FORCE_MAJEURE", "Force majeure");
define("MARK_PENDING", "Pending");
define("MEMBER_SINCE", "Member since");
define("MENUTITLE", "Link slug");
define("MESSAGE", "Message");
define("METHOD", "Method");
define("MOB", "Mobile");
define("MONAMOUNT", "Mon (amt)");
define("MONPERCENT", "Mon (%)");
define("MY_DRIVERS", "My Drivers");
define("MY_VEHICLES", "My Vehicles");
define("NAME", "Name");
define("NET_INCOME", "Commision");
define("NETTO_PRICE", "Netto Price");
define("NEW_ROUTE", "New Route");
define("NEW_TRANSFER", "New transfer");
define("NEW_USER", "Add new User");
define("NEW_PASSWORD", "New Password");
define("NEWW", "New");
define("NNEW", "New");
define("NIGHTAMOUNT", "or fixed Amount");
define("NIGHTEND", "Night ends at");
define("NIGHTPERCENT", 'Percent (%)');
define("NIGHT_SETTINGS", "Night trips");
define("NIGHTSTART", "Night starts at");
define("NO_DATA", "Nothing available");
define("NO_DRIVER", "No Driver");
define("NO", "No");
define("NO_SHOW", "No Show");
define("NO_SURCHARGES", "No Price Rules");
define("NOT_ACTIVE", "Not active");
define("NOT_CONFIRMED", "Not confirmed");
define("NOTE", "Note");
define("NOTES", "Pickup Notes");
define("NOTESS", "Notes");
define("NOTE_TO_DRIVER", "Note to Driver");
define("NO_TRANSFERS", "No transfers to show.");
define("NUMBER", "Number");
define("ONETOTWO", "A &rarr; B");
define("ONLINE", "Online");
define("OPERATOR", "Operator");
define("OPERATOR_ORDERS", "Operator orders");
define("ORDER_KEY", "Order Key");
define("ORDER_DATE", "Order date");
define("ORDER_LOG", "Timeline");
define("ORDER", "Order");
define("ORDERS", "Orders");
define("ORDERS_BY_B_DATE", "by booking date");
define("ORDERS_BY_TR_DATE", "by transfer date");
define("OWNERID", "Owner ID");
define("PAGE_NOT_FOUND", "Page not found!");
define("PAGES", "Pages");
define("PAID_ONLINE", "Paid Online");
define("PAID", "Paid");
define("PASSENGER", "Passenger");
define("PASSWORD", "Password");
define("PAX_EMAIL", "Passenger's Email");
define("PAX_TEL", "Passenger's Phone");
define("PAX_NAME", "Passenger's Name");
define("PAX_FIRST_NAME", "Pax First Name");
define("PAX_LAST_NAME", "Pax Last Name");
define("PAX", "Pax");
define("PAYMENT_FOR", "For payment");
define("PAYMENT_METHOD", "Payment method");
define("PAYMENT_STATUS", "Payment status");
define("PICKUP_ADDRESS", "Pickup Address");
define("PICKUP_DATE", "Pickup Date");
define("PICKUP_NAME", "Pickup Name");
define("PICKUP_TIME", "Pickup Time");
define("PLACETYPEEN", "Location Type (EN)");
define("PLACECOUNTRY", "Country");
define("PLACENAMEEN", "Location name (EN)");
define("PLACENAMESEO", "SEO name");
define("PLACETYPE", "Location type");
define("PLACECITY", "City");
define("PLACEADDRESS", "Address");
define("PLACEDESC", "Description");
define("PLACEACTIVE", "Active");
define("POSITION", "Position");
define("PICKUP_POINT", "Pickup Point");
define("PRICE", "Price");
define("PRICES", "All prices");
define("PRICES_EXPORT", "Export driver prices");
define("ALL_PRICES_EXPORT", "All prices export");
define("PRICES_IMPORT", "Import driver prices");
define("PRICE_SETTINGS", "Price settings");
define("PRINT_CONFIRMATION", "Print");
define("PRINT", "Print");
define("PROVISION", "Discount");
define("PROFILE", "Profile");
define("PUBLISHED", "Published");
define("QUICK_EMAIL", "Quick Email");
define("REAL_NAME", "Real name");
define("REMOVE_ROUTES_FROM_TO", "Remove all routes that <strong>begin</strong> or <strong>end</strong> at:");
define("REPORTS", "Reports");
define("RESEND_VOUCHER", "Resend Voucher");
define("RETURNDISCOUNT", "Return Discount");
define("ROUTEID", "Route ID");
define("ROUTENAME", "Route name");
define("ROUTE", "Route");
define("ROUTE_SETTINGS", "Route settings");
define("ROUTE_SPECIFIC", "Use Route Rules");
define("ROUTES", "Routes");
define("S1END", "Season 1 ends on");
define("S1PERCENT", "(%)");
define("S1START", "Season 1 starts on");
define("S2END", "Season 2 ends on");
define("S2PERCENT", "(%)");
define("S2START", "Season 2 starts on");
define("S3END", "Season 3 ends on");
define("S3PERCENT", "(%)");
define("S3START", "Season 3 starts on");
define("S4END", "Season 4 ends on");
define("S4PERCENT", "(%)");
define("S4START", "Season 4 starts on");
define("S5END", "Season 5 ends on");
define("S5PERCENT", "(%)");
define("S5START", "Season 5 starts on");
define("S6END", "Season 6 ends on");
define("S6PERCENT", "(%)");
define("S6START", "Season 6 starts on");
define("S7END", "Season 7 ends on");
define("S7PERCENT", "(%)");
define("S7START", "Season 7 starts on");
define("S8END", "Season 8 ends on");
define("S8PERCENT", "(%)");
define("S8START", "Season 8 starts on");
define("S9END", "Season 9 ends on");
define("S9PERCENT", "(%)");
define("S9START", "Season 9 starts on");
define("S10END", "Season 10 ends on");
define("S10PERCENT", "(%)");
define("S10START", "Season 10 starts on");
define("STARTSEASON", "Season start at");
define("ENDSEASON", "Season end at");
define("WEEKDAYS", "Weekdays");


define("SALES", "Sales");
define("SATAMOUNT", "Sat (amt)");
define("SATPERCENT", "Sat (%)");
define("SAVE", "Save");
define("SEND_EMAIL_TO_DRIVER", "Send e-mail to Driver");
define("SEND", "Send");
define("SERVICE", "Service");
define("SIGN_OUT", "Sign Out");
define("SITE_CONTENT", "Site content");
define("SITEID", "Site ID");
define("SITE_SETTINGS", "Site settings");
define("STATUS", "Status");
define("SUBJECT", "Subject");
define("SUNAMOUNT", "Sun (amt)");
define("SUNPERCENT", "Sun (%)");
define("SUMMARY_INVOICE_DRIVER", "Summary Invoice - Driver");
define("SURCATEGORY", "Price Rules");
define("SURCHARGES", "Price Rules");
define("SYSTEM_MESSAGES", "System messages");
define("TAXISITE", "Taxi Site");
define("TEL", "Tel");
define("THANK_YOU", "Thank You");
define("THERE_ARE_NO_DATA", '<i class="fa fa-circle-o-notch fa-spin fa-5x"></i>');
define("THERE_ARE_NO", "Loading ");
define("THERE_ARE", "Loading ");
define("THIS_WEEK", "This week");
define("THUAMOUNT", "Thu (amt)");
define("THUPERCENT", "Thu (%)");
define("TIME", "Time");
define("TITLE", "Title");
define("TODO", "To do");
define("TODAY", "Today");
define("TOMORROW", "Tomorrow");
define("TOTAL", "Total");
define("TO", "To");
define("TO_DRIVER", "To Driver");
define("TO_PAX", "To Pax");
define("TRANSFER_DATA", "Transfer data");
define("TRANSFER_FOR_YOU","
		We have new transfer(s) for you.<br>
		Please Confirm or Decline these transfers immediately using the link(s) below:<br><br>
");
define("THIS_INFO_WILL_BE_SENT_TO_CUSTOMER", "Please fill-in the following data.<br>
												If you Confirm this transfer, 
												this info will be sent to customer.");
define("TRANSFER_STATUS", "Status");
define("TRANSFERS", "Transfers");
define("TRANSFER", "Transfer");
define("TUEAMOUNT", "Tue (amt)");
define("TUEPERCENT", "Tue (%)");
define("TURNOVER", "Turnover");
define("TWOTOONE", "B &rarr; A");
define("UPDATED", "Updated");
define("UPLOAD_IMAGES", "Drop Images Here");
define("UPLOAD_NEW_IMAGE", "Upload new image");
define("UPLOAD", "Upload");
define("USE_BOTH", "Both Username and Password are required!");
define("USE_GLOBAL", "Use Global Rules");
define("USERID", "User ID");
define("USER_NAME", "User name");
define("USERS", "Users");
define("USER", "User");
define("VEHICLE", "Vehicle");
define("VEHICLES", "Vehicles");
define("VEHICLECAPACITY", "Max. Pax");
define("VEHICLEDESCRIPTION", "Veh.Description");
define("VEHICLENAME", "Vehicle name");
define("VEHICLETYPEID", "Vehicle type");
define("VEHICLE_TYPE", "Vehicle Type");
define("VEHICLE_TYPES", "Vehicle Types");
define("VEHICLEID", "Vehicle ID");
define("VEHICLE_IMAGES_NOTE", "Only .jpg files smaller than 200Kb are allowed. Preferred dimensions 200x150px.");
define("VEHICLE_IMAGES", "Vehicle images");
define("WAITING", "Waiting");
define("WEDAMOUNT", "Wed (amt)");
define("WEDPERCENT", "Wed (%)");
define("YES", "Yes");
define("AFTER_INCLUDING", "after and including");
define("AFTER", "after");
define("BEFORE", "before");
define("ON", "on");
define("SHOW_BOOKED", "Show transfers booked");
define("AND_PICKUP_DATE_IS", "AND Pickup date is");
define("AND_DRIVER_IS", "AND Driver is");
define("APPLY", "Apply filter");
define("SORT_BY_PICKUP_DATE", "Sort by Pickup date");
define("NO_ROUTE_RULES_DEFINED", "There are no Route Rules defined.");
define("SERVICE_SPECIFIC", "Use Service Rules");
define("VEHICLE_SPECIFIC", "Use Vehicle Rules");
define("DEFINE_GLOBAL", "Global Rules");
define("MOST_DECLINES", "Drivers with most declines");
define("TOP_DRIVERS", "Top drivers");
define("TOP_DEBTORS", "Largest debtors");

define("CONFIRM", "Confirm");
define("DECLINE", "Decline");
define("CONFIRM_DECLINE_INSTRUCTIONS", "You can Confirm or Decline this transfer according to T&C. If you decline this transfer, it will be assigned to the next available driver. You cannot change your decision later on!");

define("IMPORTANT_UPDATE", "Important update");
define("YOUR_NEW_DRIVER_NAME", "Your new driver name");
define("YOUR_NEW_DRIVER_TEL", "Your new driver phone");

define("VIEW_SITE", "View site");

define("ADD_ROUTES_FROM_TO", "Add Routes that <strong>begin</strong> or <strong>end</strong> at selected location");
define("PLEASE_REFRESH", "Please refresh this page.");

define("SERVICEPRICE1", "Active Price");
define("SERVICEPRICE2", "New Price");
define("SERVICEETA", "Duration");
define("VEHICLEAVAILABLE", "Vehicle Available");
define("SUBMIT_NEW_PRICES", "Submit new prices for Admin approval");
define("NEW_PRICES_INFO", "When you finish entering new prices, click the button below to inform Admin and ask for the approval for the new prices. <br>New prices will become active when approved.");

define("CONFIRM_TRANSFER", 'Please confirm this transfer:');

define("VEHICLETYPENAME", "Vehicle Type Name");
define("MIN", "Min");
define("MAX", "Max");
define("VEHICLECLASS", "Vehicle Class");
define("DESCRIPTION", "Description");
define("DESCRIPTIONEN", "Description (EN)");
define("DESCRIPTIONRU", "Description (RU)");
define("DESCRIPTIONFR", "Description (FR)");
define("DESCRIPTIONDE", "Description (DE)");
define("DESCRIPTIONIT", "Description (IT)");
define("AIRCONDITION", "Free WiFi");

// agent
define("LAST_BOOKINGS", "Recent Bookings");
define("CLICK_TO_BOOK_AGAIN", "Click on a link to book again");
define("THIS_YEAR", "This year");
define("UNPAID_INVOICES", "Amount due");
define("PAID_INVOICES", "Amount paid");
define("INVOICES", "Invoices total");
define("INVOICE", "Invoice");

// user
define("COUNTRY", "Country");
define("COUNTRY_SHORT", "Country Short");
define("CITY", "City");
define("TERMINAL", "Terminal");
define("TAX_NUMBER", "Tax Number");
define("ACCOUNT_OWNER", "Account owner");
define("ACCOUNT_BANK", "Account Bank");
define("IBAN", "IBAN");
define("SWIFT", "SWIFT");
define("FAX", "Fax");
define("PRICE_RANGE1", "Price range");
define("PRICE_RANGE2", "Price range");
define("PRICE_RANGE3", "Price range");
define("PREMIUM_PRICE_RANGE1", "Premium price range");
define("PREMIUM_PRICE_RANGE2", "Premium price range");
define("PREMIUM_PRICE_RANGE3", "Premium price range");
define("FCLASS_PRICE_RANGE1", "First Class price range");
define("FCLASS_PRICE_RANGE2", "First Class price range");
define("FCLASS_PRICE_RANGE3", "First Class price range");
define("OUR_COMMISION", "Our commission");

// timetable
define("TIMETABLE", "Timetable");
define("TRANSFER_LIST", "Transfer List");
define("SHOW_TRANSFERS", "Show Transfers");
define("REQUIRED", "Required");
define("SORT", "Sort");
define("NO_EXTRAS", "No extras");
define("STAFF_NOTE", "Staff Notes");
define("NOTES_TO_DRIVER", "Notes to Driver");
define("FINAL_NOTE", "Final Note");
define("RAZDUZENO_CASH", "Naplaćeno - Cash");
define("UPLOAD_PDF_RECEIPT", "Upload PDF Receipt");
define("DOWNLOAD_RECEIPT", "Download Receipt");
define("DELETE_RECEIPT", "Delete Receipt");
define("SUBDRIVERS", "Subdrivers");
define("MY_EXPENSES", "My Expenses");
define("EXPENSE", "Expense");
define("DATUM", "Date");
define("AMOUNT", "Amount");
define("CO_EMAIL", "Company Email");
define("CO_NAME", "Company Name");
define("CO_ADDRESS", "Company Address");
define("TELEPHONE", "Telephone");
define("EXPENSES_REPORT", "Expenses - Report");
define("SHOW_EXPENSES", "Show Expenses");
define("OPTIONAL", "optional");
define("TOTAL_CARD", "Total Card");
define("TOTAL_CASH", "Total Cash");
define("TOTAL_PAID", "Total Paid");
define("TOTAL_VALUE", "Total Value");

// reports
define("TRANSFERS_SUMMARY", "Transfers Summary");
define("TRANSFERS_SUMMARY_BOOKING", "Transfers Summary by Booking Date");
define("TRANSFERS_SUMMARY_DESCRIPTION","
&middot; canceled transfers excluded <br>
&middot; Temp transfers excluded <br>
&middot; all prices in EUR <br>
&middot; ordered by Date <br>
");
define("BOOKING_DATE", "Booking Date");
define("SHOW_DETAILS", "Show details");
define("SUBMIT", "Submit");
define("TOTAL_TRANSFERS", "Total number of transfers");
define("CARD", "Card");
define("NETTO", "Net Income");
define("ADMIN_ORDERS", "Admin orders");
define("AGENT_ORDERS", "Agent orders");
define("API_ORDERS", "API orders");
define("TAXI_SITE_ORDERS", "Taxi site orders");
define("SITE_ORDERS", "Site orders");
define("LEGEND", "Legend");
define("PRICE_LIST", "Price list");
define("SUMMARY_INVOICE_AGENT", "Summary Invoice Agent");
define("AGENTS_WITH_TRANSFERS", "Agents with transfers");
define("AGENTS_BALANCE", "Agent transfers");
define("EXCHANGE_RATE", "Exchange Rate");
define("EUR_TO_RSD", "1 EUR = ");
define("SET_NEW_RATE", "Save New Rate");
define("INVOICES_AGENTS", "Invoices");
define("NEW_AGENT_INVOICE", "New Agent Invoice");
define("NEW_DRIVER_INVOICE", "New Driver Invoice");
define("STARTDATE", "Start date");
define("ENDDATE", "End date");
define("INVOICENUMBER", "Invoice Number");
define("INVOICEDATE", "Invoice Date");
define("AMOUNTEUR", "Total EUR");
define("VATTOTAL", "Total VAT");
define("CLIENT_EMAILS", "Client Emails");
define("CLIENT_EMAIL_LIST", "Client Email List");
define("DRIVERS_EMAIL_LIST", "Drivers Email List");
define("SHOW_CLIENTS", "Show Clients");
define("SHOW_EMAILS", "Show Emails");
define("USER_TYPE", "User Type");
define("AGENT_REPORT", "Agent Report");

// driver confirmation
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


// translator
define("POLICIES", "Policies");
define("ENGLISH", "English");
define("RUSSIAN", "Russian");
define("FRENCH", "French");
define("GERMAN", "German");
define("ITALIAN", "Italian");
define("LEN", " (EN)");
define("LRU", " (RU)");
define("LFR", " (FR)");
define("LDE", " (DE)");
define("LIT", " (IT)");
define("COUNTRYNAME", "Country name");
define("COUNTRYDESC", "Country description");
define("PLACENAME", "Location name");

define("DRIVER_PRICE", "Driver Price");
define("PROVISIONPERC", "Provision %");

define("COUNTRYISO", "Country ISO");
define("COUNTRYCODE", "Country code");
define("COUNTRYCODE3", "Country code 3");
define("PHONEPREFIX", "Phone prefix");

// coupons
define("CODE", "Code");
define("VALIDFROM", "Valid From");
define("VALIDTO", "Valid To");
define("TRANSFERFROMDATE", "From Date");
define("TRANSFERTODATE", "To Date");
define("LIMITLOCATIONID", "Limit Location");
define("WEEKDAYSONLY", "Weekdays Only");
define("RETURNONLY", "Return Only");
define("TIMESUSED", "Times Used");

define("REFRESH_CACHE", "Refresh Cache");

// reviews
define("SURVEY", "Survey");
define("SEND_EMAIL_SURVEY", "Send Email Survey");
define("SURVEY_SENT", "Survey sent at");
define("ROUTE_REVIEWS", "Reviews");
define("ORDERID", "Order ID");
define("USEREMAIL", "User Email");
define("USERNAME", "User Name");
define("COMMENT", "Comment");
define("SCORESERVICE", "Score - Service");
define("SCOREDRIVER", "Score - Driver");
define("SCORECLEAN", "Score - Cleanliness");
define("SCOREVALUE", "Score - Value for money");
define("SCOREWEBSITE", "Score - Website");
define("SCORETOTAL", "Score - Total");
define("DRIVERONTIME", "Was driver on time");
define("RECOMMEND", "Would recommend");
define("BOOKAGAIN", "Would book again");
define("SURVEY_REPORT", "Survey - Report");
define("SHOW_REVIEWS", "Show results");
define("SURVEY_RESULTS_LIST", "Survey results - List");

define("EXTRA_SERVICES", "Extras Master");
define("ANY", "All");
define("ONLY_EXTRAS", "Only with extras");

define("PAY_CASH", "Cash");
define("PAY_INVOICE", "Bank transfer");
define("PAY_ONLINE", "Online");

// Josip Special Dates
define("SPECIALDATE", "Date");
define("SPECIALDATES", "Special Dates");
define("SPECIALTIMES", "Special Times");
define("STARTTIME", "Start Time");
define("ENDTIME", "End Time");
define("CORRECTIONPERCENT", "Percent");

//Company info - Leo
define("CO_TEL", "Company phone");
define("CO_FAX", "Company fax");
define("CO_CITY", "Company city");
define("CO_COUNTRY", "Company country");
define("CO_ZIP", "Company ZIP Code");
define("CO_TAXNO", "Company tax number");
define("CO_BANK", "Company bank");
define("CO_ACCOUNTNO", "Company account number");
define("CO_IBAN", "Company IBAN");
define("CO_SWIFT", "Company SWIFT code");
define("CO_DOMESTICTAX", "Company domestic tax");
define("CO_FOREIGNTAX", "Company foreign tax");
define("CO_EURINFO", "Company EUR info");
define("CO_PAYMENTINFO", "Company payment info");
define("CO_FACEBOOK", "Facebook");
define("CO_TWITTER", "Twitter");
define("CO_LINKEDIN", "LinkedIn");
define("CO_YOUTUBE", "Youtube");
define("CO_GOOGLEPLUS", "Google+");

//Extra Services
define("DISPLAYORDER", "Service Display order");
define("SERVICEEN", "Extra service (EN)");
define("SERVICEDE", "Extra service (DE)");
define("SERVICERU", "Extra service (RU)");
define("SERVICEFR", "Extra service (FR)");
define("SERVICEIT", "Extra service (IT)");
define("SERVICESE", "Extra service (SE)");
define("SERVICENO", "Extra service (NO)");
define("SERVICEES", "Extra service (ES)");
define("SERVICENL", "Extra service (NL)");
define("LSE", " (SE)");
define("LNO", " (NO)");
define("LES", " (ES)");
define("LNL", " (NL)");
define("COUNTRYNAMERU", "Country name (RU)");
define("DESCRIPTIONSE", "Description (SE)");
define("DESCRIPTIONNO", "Description (NO)");
define("DESCRIPTIONES", "Description (ES)");
define("DESCRIPTIONNL", "Description (NL)");
define("SUBDRIVER_HISTORY", "Subdriver History");
define("AGENT_TRANSFERS", "Agent transfers");
define("DEPOSIT", "Deposit (EUR)");
/*
$smarty->assign("ACCEPTED_PAYMENT", "Accepted Payment");
$smarty->assign("ACTIONS", "Actions");
$smarty->assign("ACTIVE", "Active");
$smarty->assign("ADD", "Add");
$smarty->assign("ADDRESS", "Address");
$smarty->assign("ADMIN", "Admin");
$smarty->assign("ADMIN_NOTES", "Staff Notes");
$smarty->assign("ADVANCED_SEARCH", "Advanced Search");
$smarty->assign("AFFILIATE", "Affiliate");
$smarty->assign("AGENT", "Agent");
$smarty->assign("AGENT_COMMISION", "Ag.Comm.");
$smarty->assign("AGENTS", "Agent orders");
$smarty->assign("ALL", "All");
$smarty->assign("ALL_DRIVERS", "All Drivers");
$smarty->assign("ALL_TRANSFERS", "All Transfers");
$smarty->assign("APIUSER", "API User");
$smarty->assign("APPROVED", "Approved");
$smarty->assign("ARTICLE", "Article");
$smarty->assign("ARTICLES", "Articles");
$smarty->assign("ASCENDING", "Ascending");
$smarty->assign("ASSIGNED_TO_ANOTHER_DRIVER", "This Transfer is assigned to another driver and removed from Your transfers list.");
$smarty->assign("BALANCE", "Balance");
$smarty->assign("BASE_PRICE", "Base Price");
$smarty->assign("BOOKED_BY", "Booked by");
$smarty->assign("BOOKING", "Booking");
$smarty->assign("BOOKINGS", "Bookings");
$smarty->assign("BRAND_NAME", "Brand name");
$smarty->assign("BY_BOOKING_DATE", "by booking date");
$smarty->assign("BY_TRANSFER_DATE", "by transfer date");
$smarty->assign("CALENDAR", "Calendar");
$smarty->assign("CANCELED_ORDERS", "Cancelled orders");
$smarty->assign("CANCELLED", "Cancelled");
$smarty->assign("CANCEL_TRANSFER", "Cancel transfer");
$smarty->assign("CASH", "Cash");
$smarty->assign("CLOSE", "Close");
$smarty->assign("COMPANY_ADDRESS", "Company address");
$smarty->assign("COMPANY_DESC", "Company description");
$smarty->assign("COMPANY_INFO", "Company Info");
$smarty->assign("COMPANY_NAME", "Company name");
$smarty->assign("COMPANY_TEXTS", "Various articles");
$smarty->assign("COMPANY_WEB", "Company web");
$smarty->assign("COMPLETED", "Completed");
$smarty->assign("CONFIRMED", "Ready");
$smarty->assign("CONTACT_PERSON", "Contact person");
$smarty->assign("CONTENT", "Content");
$smarty->assign("CONTRACT_FILE", "Contract file");
$smarty->assign("CONTRACT_DATE", "Contract date");
$smarty->assign("CONTRACT_SIGNATURE", "Contract signature");
$smarty->assign("COUNTRIES", "Countries");
$smarty->assign("COUNTRY_CURRENCY", "Country currency");
$smarty->assign("COUNTRY_NAME", "Country name");
$smarty->assign("COUNTRY_NAME_RU", "Country name in Russian");
$smarty->assign("COUPONS", "Coupons");
$smarty->assign("COUPON_DISCOUNT", "Coupon discount");
$smarty->assign("CURRENCY", 'Eur');
$smarty->assign("CURRENCYTYPE", 'Currency');
$smarty->assign("CURRENT_PRICE", "Active Price");
$smarty->assign("CUSTOM", "Custom");
$smarty->assign("CUSTOMER", "Customer");
$smarty->assign("DASHBOARD", "Dashboard");
$smarty->assign("DATE", "Date");
$smarty->assign("DATE_ADDED", "Date added");
$smarty->assign("DATA", "data");
$smarty->assign("DATA_CHECKED", "Data checked");
$smarty->assign("DATE_SETTINGS", "Off-Duty Dates");
$smarty->assign("DAY_SETTINGS", "Days of the week");
$smarty->assign("DECLINED", "Declined");
$smarty->assign("DELETE_COUNTRY", "Delete Country");
$smarty->assign("DELETE", "Delete");
$smarty->assign("DELETE_CACHE", "Delete cache");
$smarty->assign("DELETE_IMAGE", "Delete image");
$smarty->assign("DELETE_TRANSFER", "Delete transfer");
$smarty->assign("DELETE_USER", "Delete User");
$smarty->assign("DESCENDING", "Descending");
$smarty->assign("DETAIL_DESCRIPTION", "Please enter detailed description");
$smarty->assign("DISCOUNT", "Return Discount");
$smarty->assign("DISPLAY_ALL", "Display all");
$smarty->assign("DISPLAY_NOT_CHECKED", "Display not checked");
$smarty->assign("DRIVER", "Driver");
$smarty->assign("DRIVER_EMAIL", "Driver's Email");
$smarty->assign("DRIVER_ERROR", "Driver Error");
$smarty->assign("DRIVER_NAME", "Driver's Name");
$smarty->assign("DRIVER_PAID_AMOUNT", "Amount");
$smarty->assign("DRIVER_PAYMENT", "Driver Payment");
$smarty->assign("DRIVERS_BALANCE", "Driver's Balance");
$smarty->assign("DRIVERS_WITH_TRANSFERS", "Drivers with transfers");
$smarty->assign("DRIVERS_PRICE", "Driver's Price");
$smarty->assign("DRIVER_ROUTES", "Driver Routes");
$smarty->assign("DRIVERS", "Drivers");
$smarty->assign("DRIVER_STATUS", "Transfer status");
$smarty->assign("DRIVER_TEL", "Driver's Tel");
$smarty->assign("DROPOFF_ADDRESS", "Drop-Off Address");
$smarty->assign("DROPOFF_NAME", "Drop-Off Name");
$smarty->assign("DURATION", "Duration");
$smarty->assign("EDIT", "Edit");
$smarty->assign("EMAIL", "E-mail");
$smarty->assign("EMAIL_TO", "E-mail to");
$smarty->assign("EMERGENCY_PHONE", "Emergency phone");
$smarty->assign("EXTRAS", "Extra services");
$smarty->assign("FACEBOOK", "Facebook");
$smarty->assign("FINDER", "Finder");
$smarty->assign("FLIGHT_NO", "Flight Number");
$smarty->assign("FLIGHT_TIME", "Flight Time");
$smarty->assign("FREEFORM", "Free form transfer");
$smarty->assign("FRIAMOUNT", "Fri (amt)");
$smarty->assign("FRIPERCENT", "Fri (%)");
$smarty->assign("FROM", "From");
$smarty->assign("GOOGLE_PLUS", "Google+");
$smarty->assign("GRAPH", "Graph");
$smarty->assign("HEADER_IMAGES", "Header Images");
$smarty->assign("HELLO", "Hello");
$smarty->assign("ID", "ID");
$smarty->assign("IMAGE", "Image");
$smarty->assign("IMAGE_MANAGER", "Image manager");
$smarty->assign("ISLAND", "On island");
$smarty->assign("KEY", "Key");
$smarty->assign("LANGUAGE", "Language");
$smarty->assign("LASTCHANGE", "Last Change");
$smarty->assign("LAST_VISIT", "Last visit");
$smarty->assign("LEVEL", "Level");
$smarty->assign("LINKEDIN", "LinkedIn");
$smarty->assign("LIST", "List");
$smarty->assign("LOADING", "Loading...");
$smarty->assign("LOCATION", "Location");
$smarty->assign("LOCATIONS", "Locations");
$smarty->assign("LOCATION_TYPES", "Location Types");
$smarty->assign("LOGIN_FAILED", "Login failed!");
$smarty->assign("MARK_ACTIVE", "Mark Active");
$smarty->assign("MARK_COMPLETED", "Mark Completed");
$smarty->assign("MARK_NOSHOW", "No-Show");
$smarty->assign("MARK_ERROR", "Errors");
$smarty->assign("MARK_DRIVER_ERROR", "Driver Error");
$smarty->assign("MARK_OPERATOR_ERROR", "Operator Error");
$smarty->assign("MARK_DISPATCHER_ERROR", "Dispatcher Error");
$smarty->assign("MARK_AGENT_ERROR", "Agent Error");
$smarty->assign("MARK_FORCE_MAJEURE", "Force majeure");
$smarty->assign("MARK_PENDING", "Pending");
$smarty->assign("MEMBER_SINCE", "Member since");
$smarty->assign("MENUTITLE", "Link slug");
$smarty->assign("MESSAGE", "Message");
$smarty->assign("METHOD", "Method");
$smarty->assign("MOB", "Mobile");
$smarty->assign("MONAMOUNT", "Mon (amt)");
$smarty->assign("MONPERCENT", "Mon (%)");
$smarty->assign("MY_DRIVERS", "My Drivers");
$smarty->assign("MY_VEHICLES", "My Vehicles");
$smarty->assign("NAME", "Name");
$smarty->assign("NET_INCOME", "Commision");
$smarty->assign("NETTO_PRICE", "Netto Price");
$smarty->assign("NEW_ROUTE", "New Route");
$smarty->assign("NEW_TRANSFER", "New transfer");
$smarty->assign("NEW_USER", "Add new User");
$smarty->assign("NEW_PASSWORD", "New Password");
$smarty->assign("NEWW", "New");
$smarty->assign("NNEW", "New");
$smarty->assign("NIGHTAMOUNT", "or fixed Amount");
$smarty->assign("NIGHTEND", "Night ends at");
$smarty->assign("NIGHTPERCENT", 'Percent (%)');
$smarty->assign("NIGHT_SETTINGS", "Night trips");
$smarty->assign("NIGHTSTART", "Night starts at");
$smarty->assign("NO_DATA", "Nothing available");
$smarty->assign("NO_DRIVER", "No Driver");
$smarty->assign("NO", "No");
$smarty->assign("NO_SHOW", "No Show");
$smarty->assign("NO_SURCHARGES", "No Price Rules");
$smarty->assign("NOT_ACTIVE", "Not active");
$smarty->assign("NOT_CONFIRMED", "Not confirmed");
$smarty->assign("NOTE", "Note");
$smarty->assign("NOTES", "Pickup Notes");
$smarty->assign("NOTESS", "Notes");
$smarty->assign("NOTE_TO_DRIVER", "Note to Driver");
$smarty->assign("NO_TRANSFERS", "No transfers to show.");
$smarty->assign("NUMBER", "Number");
$smarty->assign("ONETOTWO", "A &rarr; B");
$smarty->assign("ONLINE", "Online");
$smarty->assign("OPERATOR", "Operator");
$smarty->assign("OPERATOR_ORDERS", "Operator orders");
$smarty->assign("ORDER_KEY", "Order Key");
$smarty->assign("ORDER_DATE", "Order date");
$smarty->assign("ORDER_LOG", "Timeline");
$smarty->assign("ORDER", "Order");
$smarty->assign("ORDERS", "Orders");
$smarty->assign("ORDERS_BY_B_DATE", "by booking date");
$smarty->assign("ORDERS_BY_TR_DATE", "by transfer date");
$smarty->assign("OWNERID", "Owner ID");
$smarty->assign("PAGE_NOT_FOUND", "Page not found!");
$smarty->assign("PAGES", "Pages");
$smarty->assign("PAID_ONLINE", "Paid Online");
$smarty->assign("PAID", "Paid");
$smarty->assign("PASSENGER", "Passenger");
$smarty->assign("PASSWORD", "Password");
$smarty->assign("PAX_EMAIL", "Passenger's Email");
$smarty->assign("PAX_TEL", "Passenger's Phone");
$smarty->assign("PAX_NAME", "Passenger's Name");
$smarty->assign("PAX_FIRST_NAME", "Pax First Name");
$smarty->assign("PAX_LAST_NAME", "Pax Last Name");
$smarty->assign("PAX", "Pax");
$smarty->assign("PAYMENT_FOR", "For payment");
$smarty->assign("PAYMENT_METHOD", "Payment method");
$smarty->assign("PAYMENT_STATUS", "Payment status");
$smarty->assign("PICKUP_ADDRESS", "Pickup Address");
$smarty->assign("PICKUP_DATE", "Pickup Date");
$smarty->assign("PICKUP_NAME", "Pickup Name");
$smarty->assign("PICKUP_TIME", "Pickup Time");
$smarty->assign("PLACETYPEEN", "Location Type (EN)");
$smarty->assign("PLACECOUNTRY", "Country");
$smarty->assign("PLACENAMEEN", "Location name (EN)");
$smarty->assign("PLACENAMESEO", "SEO name");
$smarty->assign("PLACETYPE", "Location type");
$smarty->assign("PLACECITY", "City");
$smarty->assign("PLACEADDRESS", "Address");
$smarty->assign("PLACEDESC", "Description");
$smarty->assign("PLACEACTIVE", "Active");
$smarty->assign("POSITION", "Position");
$smarty->assign("PICKUP_POINT", "Pickup Point");
$smarty->assign("PRICE", "Price");
$smarty->assign("PRICES", "All prices");
$smarty->assign("PRICES_EXPORT", "Export driver prices");
$smarty->assign("ALL_PRICES_EXPORT", "All prices export");
$smarty->assign("PRICES_IMPORT", "Import driver prices");
$smarty->assign("PRICE_SETTINGS", "Price settings");
$smarty->assign("PRINT_CONFIRMATION", "Print");
$smarty->assign("PRINT", "Print");
$smarty->assign("PROVISION", "Discount");
$smarty->assign("PROFILE", "Profile");
$smarty->assign("PUBLISHED", "Published");
$smarty->assign("QUICK_EMAIL", "Quick Email");
$smarty->assign("REAL_NAME", "Real name");
$smarty->assign("REMOVE_ROUTES_FROM_TO", "Remove all routes that <strong>begin</strong> or <strong>end</strong> at:");
$smarty->assign("REPORTS", "Reports");
$smarty->assign("RESEND_VOUCHER", "Resend Voucher");
$smarty->assign("RETURNDISCOUNT", "Return Discount");
$smarty->assign("ROUTEID", "Route ID");
$smarty->assign("ROUTENAME", "Route name");
$smarty->assign("ROUTE", "Route");
$smarty->assign("ROUTE_SETTINGS", "Route settings");
$smarty->assign("ROUTE_SPECIFIC", "Use Route Rules");
$smarty->assign("ROUTES", "Routes");
$smarty->assign("S1END", "Season 1 ends on");
$smarty->assign("S1PERCENT", "(%)");
$smarty->assign("S1START", "Season 1 starts on");
$smarty->assign("S2END", "Season 2 ends on");
$smarty->assign("S2PERCENT", "(%)");
$smarty->assign("S2START", "Season 2 starts on");
$smarty->assign("S3END", "Season 3 ends on");
$smarty->assign("S3PERCENT", "(%)");
$smarty->assign("S3START", "Season 3 starts on");
$smarty->assign("S4END", "Season 4 ends on");
$smarty->assign("S4PERCENT", "(%)");
$smarty->assign("S4START", "Season 4 starts on");
$smarty->assign("S5END", "Season 5 ends on");
$smarty->assign("S5PERCENT", "(%)");
$smarty->assign("S5START", "Season 5 starts on");
$smarty->assign("S6END", "Season 6 ends on");
$smarty->assign("S6PERCENT", "(%)");
$smarty->assign("S6START", "Season 6 starts on");
$smarty->assign("S7END", "Season 7 ends on");
$smarty->assign("S7PERCENT", "(%)");
$smarty->assign("S7START", "Season 7 starts on");
$smarty->assign("S8END", "Season 8 ends on");
$smarty->assign("S8PERCENT", "(%)");
$smarty->assign("S8START", "Season 8 starts on");
$smarty->assign("S9END", "Season 9 ends on");
$smarty->assign("S9PERCENT", "(%)");
$smarty->assign("S9START", "Season 9 starts on");
$smarty->assign("S10END", "Season 10 ends on");
$smarty->assign("S10PERCENT", "(%)");
$smarty->assign("S10START", "Season 10 starts on");
$smarty->assign("STARTSEASON", "Season start at");
$smarty->assign("ENDSEASON", "Season end at");
$smarty->assign("WEEKDAYS", "Weekdays");


$smarty->assign("SALES", "Sales");
$smarty->assign("SATAMOUNT", "Sat (amt)");
$smarty->assign("SATPERCENT", "Sat (%)");
$smarty->assign("SAVE", "Save");
$smarty->assign("SEND_EMAIL_TO_DRIVER", "Send e-mail to Driver");
$smarty->assign("SEND", "Send");
$smarty->assign("SERVICE", "Service");
$smarty->assign("SIGN_OUT", "Sign Out");
$smarty->assign("SITE_CONTENT", "Site content");
$smarty->assign("SITEID", "Site ID");
$smarty->assign("SITE_SETTINGS", "Site settings");
$smarty->assign("STATUS", "Status");
$smarty->assign("SUBJECT", "Subject");
$smarty->assign("SUNAMOUNT", "Sun (amt)");
$smarty->assign("SUNPERCENT", "Sun (%)");
$smarty->assign("SUMMARY_INVOICE_DRIVER", "Summary Invoice - Driver");
$smarty->assign("SURCATEGORY", "Price Rules");
$smarty->assign("SURCHARGES", "Price Rules");
$smarty->assign("SYSTEM_MESSAGES", "System messages");
$smarty->assign("TAXISITE", "Taxi Site");
$smarty->assign("TEL", "Tel");
$smarty->assign("THANK_YOU", "Thank You");
$smarty->assign("THERE_ARE_NO_DATA", '<i class="fa fa-circle-o-notch fa-spin fa-5x"></i>');
$smarty->assign("THERE_ARE_NO", "Loading ");
$smarty->assign("THERE_ARE", "Loading ");
$smarty->assign("THIS_WEEK", "This week");
$smarty->assign("THUAMOUNT", "Thu (amt)");
$smarty->assign("THUPERCENT", "Thu (%)");
$smarty->assign("TIME", "Time");
$smarty->assign("TITLE", "Title");
$smarty->assign("TODO", "To do");
$smarty->assign("TODAY", "Today");
$smarty->assign("TOMORROW", "Tomorrow");
$smarty->assign("TOTAL", "Total");
$smarty->assign("TO", "To");
$smarty->assign("TO_DRIVER", "To Driver");
$smarty->assign("TO_PAX", "To Pax");
$smarty->assign("TRANSFER_DATA", "Transfer data");
$smarty->assign("TRANSFER_FOR_YOU","
		We have new transfer(s) for you.<br>
		Please Confirm or Decline these transfers immediately using the link(s) below:<br><br>
");
$smarty->assign("THIS_INFO_WILL_BE_SENT_TO_CUSTOMER", "Please fill-in the following data.<br>
												If you Confirm this transfer, 
												this info will be sent to customer.");
$smarty->assign("TRANSFER_STATUS", "Status");
$smarty->assign("TRANSFERS", "Transfers");
$smarty->assign("TRANSFER", "Transfer");
$smarty->assign("TUEAMOUNT", "Tue (amt)");
$smarty->assign("TUEPERCENT", "Tue (%)");
$smarty->assign("TURNOVER", "Turnover");
$smarty->assign("TWOTOONE", "B &rarr; A");
$smarty->assign("UPDATED", "Updated");
$smarty->assign("UPLOAD_IMAGES", "Drop Images Here");
$smarty->assign("UPLOAD_NEW_IMAGE", "Upload new image");
$smarty->assign("UPLOAD", "Upload");
$smarty->assign("USE_BOTH", "Both Username and Password are required!");
$smarty->assign("USE_GLOBAL", "Use Global Rules");
$smarty->assign("USERID", "User ID");
$smarty->assign("USER_NAME", "User name");
$smarty->assign("USERS", "Users");
$smarty->assign("USER", "User");
$smarty->assign("VEHICLE", "Vehicle");
$smarty->assign("VEHICLES", "Vehicles");
$smarty->assign("VEHICLECAPACITY", "Max. Pax");
$smarty->assign("VEHICLEDESCRIPTION", "Veh.Description");
$smarty->assign("VEHICLENAME", "Vehicle name");
$smarty->assign("VEHICLETYPEID", "Vehicle type");
$smarty->assign("VEHICLE_TYPE", "Vehicle Type");
$smarty->assign("VEHICLE_TYPES", "Vehicle Types");
$smarty->assign("VEHICLEID", "Vehicle ID");
$smarty->assign("VEHICLE_IMAGES_NOTE", "Only .jpg files smaller than 200Kb are allowed. Preferred dimensions 200x150px.");
$smarty->assign("VEHICLE_IMAGES", "Vehicle images");
$smarty->assign("WAITING", "Waiting");
$smarty->assign("WEDAMOUNT", "Wed (amt)");
$smarty->assign("WEDPERCENT", "Wed (%)");
$smarty->assign("YES", "Yes");
$smarty->assign("AFTER_INCLUDING", "after and including");
$smarty->assign("AFTER", "after");
$smarty->assign("BEFORE", "before");
$smarty->assign("ON", "on");
$smarty->assign("SHOW_BOOKED", "Show transfers booked");
$smarty->assign("AND_PICKUP_DATE_IS", "AND Pickup date is");
$smarty->assign("AND_DRIVER_IS", "AND Driver is");
$smarty->assign("APPLY", "Apply filter");
$smarty->assign("SORT_BY_PICKUP_DATE", "Sort by Pickup date");
$smarty->assign("NO_ROUTE_RULES_DEFINED", "There are no Route Rules defined.");
$smarty->assign("SERVICE_SPECIFIC", "Use Service Rules");
$smarty->assign("VEHICLE_SPECIFIC", "Use Vehicle Rules");
$smarty->assign("DEFINE_GLOBAL", "Global Rules");
$smarty->assign("MOST_DECLINES", "Drivers with most declines");
$smarty->assign("TOP_DRIVERS", "Top drivers");
$smarty->assign("TOP_DEBTORS", "Largest debtors");

$smarty->assign("CONFIRM", "Confirm");
$smarty->assign("DECLINE", "Decline");
$smarty->assign("CONFIRM_DECLINE_INSTRUCTIONS", "You can Confirm or Decline this transfer according to T&C. If you decline this transfer, it will be assigned to the next available driver. You cannot change your decision later on!");

$smarty->assign("IMPORTANT_UPDATE", "Important update");
$smarty->assign("YOUR_NEW_DRIVER_NAME", "Your new driver name");
$smarty->assign("YOUR_NEW_DRIVER_TEL", "Your new driver phone");

$smarty->assign("VIEW_SITE", "View site");

$smarty->assign("ADD_ROUTES_FROM_TO", "Add Routes that <strong>begin</strong> or <strong>end</strong> at selected location");
$smarty->assign("PLEASE_REFRESH", "Please refresh this page.");

$smarty->assign("SERVICEPRICE1", "Active Price");
$smarty->assign("SERVICEPRICE2", "New Price");
$smarty->assign("SERVICEETA", "Duration");
$smarty->assign("VEHICLEAVAILABLE", "Vehicle Available");
$smarty->assign("SUBMIT_NEW_PRICES", "Submit new prices for Admin approval");
$smarty->assign("NEW_PRICES_INFO", "When you finish entering new prices, click the button below to inform Admin and ask for the approval for the new prices. <br>New prices will become active when approved.");

$smarty->assign("CONFIRM_TRANSFER", 'Please confirm this transfer:');

$smarty->assign("VEHICLETYPENAME", "Vehicle Type Name");
$smarty->assign("MIN", "Min");
$smarty->assign("MAX", "Max");
$smarty->assign("VEHICLECLASS", "Vehicle Class");
$smarty->assign("DESCRIPTION", "Description");
$smarty->assign("DESCRIPTIONEN", "Description (EN)");
$smarty->assign("DESCRIPTIONRU", "Description (RU)");
$smarty->assign("DESCRIPTIONFR", "Description (FR)");
$smarty->assign("DESCRIPTIONDE", "Description (DE)");
$smarty->assign("DESCRIPTIONIT", "Description (IT)");
$smarty->assign("AIRCONDITION", "Free WiFi");

// agent
$smarty->assign("LAST_BOOKINGS", "Recent Bookings");
$smarty->assign("CLICK_TO_BOOK_AGAIN", "Click on a link to book again");
$smarty->assign("THIS_YEAR", "This year");
$smarty->assign("UNPAID_INVOICES", "Amount due");
$smarty->assign("PAID_INVOICES", "Amount paid");
$smarty->assign("PROVISION", "Agent commission");
$smarty->assign("INVOICES", "Invoices total");
$smarty->assign("INVOICE", "Invoice");

// user
$smarty->assign("COUNTRY", "Country");
$smarty->assign("COUNTRY_SHORT", "Country Short");
$smarty->assign("CITY", "City");
$smarty->assign("TERMINAL", "Terminal");
$smarty->assign("TAX_NUMBER", "Tax Number");
$smarty->assign("ACCOUNT_OWNER", "Account owner");
$smarty->assign("ACCOUNT_BANK", "Account Bank");
$smarty->assign("IBAN", "IBAN");
$smarty->assign("SWIFT", "SWIFT");
$smarty->assign("FAX", "Fax");
$smarty->assign("PRICE_RANGE1", "Price range");
$smarty->assign("PRICE_RANGE2", "Price range");
$smarty->assign("PRICE_RANGE3", "Price range");
$smarty->assign("PREMIUM_PRICE_RANGE1", "Premium price range");
$smarty->assign("PREMIUM_PRICE_RANGE2", "Premium price range");
$smarty->assign("PREMIUM_PRICE_RANGE3", "Premium price range");
$smarty->assign("FCLASS_PRICE_RANGE1", "First Class price range");
$smarty->assign("FCLASS_PRICE_RANGE2", "First Class price range");
$smarty->assign("FCLASS_PRICE_RANGE3", "First Class price range");
$smarty->assign("OUR_COMMISION", "Our commission");

// timetable
$smarty->assign("TIMETABLE", "Timetable");
$smarty->assign("TRANSFER_LIST", "Transfer List");
$smarty->assign("SHOW_TRANSFERS", "Show Transfers");
$smarty->assign("REQUIRED", "Required");
$smarty->assign("SORT", "Sort");
$smarty->assign("NO_EXTRAS", "No extras");
$smarty->assign("STAFF_NOTE", "Staff Notes");
$smarty->assign("NOTES_TO_DRIVER", "Notes to Driver");
$smarty->assign("FINAL_NOTE", "Final Note");
$smarty->assign("RAZDUZENO_CASH", "Naplaćeno - Cash");
$smarty->assign("UPLOAD_PDF_RECEIPT", "Upload PDF Receipt");
$smarty->assign("DOWNLOAD_RECEIPT", "Download Receipt");
$smarty->assign("DELETE_RECEIPT", "Delete Receipt");
$smarty->assign("SUBDRIVERS", "Subdrivers");
$smarty->assign("MY_EXPENSES", "My Expenses");
$smarty->assign("EXPENSE", "Expense");
$smarty->assign("DATUM", "Date");
$smarty->assign("AMOUNT", "Amount");
$smarty->assign("CO_EMAIL", "Company Email");
$smarty->assign("CO_NAME", "Company Name");
$smarty->assign("CO_ADDRESS", "Company Address");
$smarty->assign("TELEPHONE", "Telephone");
$smarty->assign("EXPENSES_REPORT", "Expenses - Report");
$smarty->assign("SHOW_EXPENSES", "Show Expenses");
$smarty->assign("OPTIONAL", "optional");
$smarty->assign("NOTESS", "Notes");
$smarty->assign("TOTAL_CARD", "Total Card");
$smarty->assign("TOTAL_CASH", "Total Cash");
$smarty->assign("TOTAL_PAID", "Total Paid");
$smarty->assign("TOTAL_VALUE", "Total Value");

// reports
$smarty->assign("TRANSFERS_SUMMARY", "Transfers Summary");
$smarty->assign("TRANSFERS_SUMMARY_BOOKING", "Transfers Summary by Booking Date");
$smarty->assign("TRANSFERS_SUMMARY_DESCRIPTION","
&middot; canceled transfers excluded <br>
&middot; Temp transfers excluded <br>
&middot; all prices in EUR <br>
&middot; ordered by Date <br>
");
$smarty->assign("BOOKING_DATE", "Booking Date");
$smarty->assign("SHOW_DETAILS", "Show details");
$smarty->assign("SUBMIT", "Submit");
$smarty->assign("TOTAL_TRANSFERS", "Total number of transfers");
$smarty->assign("CARD", "Card");
$smarty->assign("NETTO", "Net Income");
$smarty->assign("ADMIN_ORDERS", "Admin orders");
$smarty->assign("AGENT_ORDERS", "Agent orders");
$smarty->assign("API_ORDERS", "API orders");
$smarty->assign("TAXI_SITE_ORDERS", "Taxi site orders");
$smarty->assign("SITE_ORDERS", "Site orders");
$smarty->assign("LEGEND", "Legend");
$smarty->assign("PRICE_LIST", "Price list");
$smarty->assign("SUMMARY_INVOICE_AGENT", "Summary Invoice Agent");
$smarty->assign("AGENTS_WITH_TRANSFERS", "Agents with transfers");
$smarty->assign("AGENTS_BALANCE", "Agent transfers");
$smarty->assign("EXCHANGE_RATE", "Exchange Rate");
$smarty->assign("EUR_TO_RSD", "1 EUR = ");
$smarty->assign("SET_NEW_RATE", "Save New Rate");
$smarty->assign("INVOICES_AGENTS", "Invoices");
$smarty->assign("NEW_AGENT_INVOICE", "New Agent Invoice");
$smarty->assign("NEW_DRIVER_INVOICE", "New Driver Invoice");
$smarty->assign("STARTDATE", "Start date");
$smarty->assign("ENDDATE", "End date");
$smarty->assign("INVOICENUMBER", "Invoice Number");
$smarty->assign("INVOICEDATE", "Invoice Date");
$smarty->assign("AMOUNTEUR", "Total EUR");
$smarty->assign("VATTOTAL", "Total VAT");
$smarty->assign("CLIENT_EMAILS", "Client Emails");
$smarty->assign("CLIENT_EMAIL_LIST", "Client Email List");
$smarty->assign("DRIVERS_EMAIL_LIST", "Drivers Email List");
$smarty->assign("SHOW_CLIENTS", "Show Clients");
$smarty->assign("SHOW_EMAILS", "Show Emails");
$smarty->assign("USER_TYPE", "User Type");
$smarty->assign("AGENT_REPORT", "Agent Report");
$smarty->assign("APPROVED", "Approved");

// driver confirmation
	$smarty->assign("SERVICES_DESC1", "
		Service includes vehicle and driver
	");

	$smarty->assign("SERVICES_DESC2", "
		Prices are per vehicle, not per person
	");
	
	$smarty->assign("SERVICES_DESC5", "
		One piece of medium luggage and one piece of hand luggage per passenger are free of charge
	");
	
	$smarty->assign("SERVICES_DESC6", "
		We will send you driver`s contact information by email
	");
	
	$smarty->assign("SERVICES_DESC7", "
			Your driver will meet you with the nameplate at the pick up point. Keep your phone turned on
	");
	
	$smarty->assign("SERVICES_DESC3", "
			Waiting at the airports up to one hour after landing time is free 
	");

	$smarty->assign("SERVICES_DESC4", "
			 Flight delays are monitored
	");
	
	$smarty->assign("SERVICES_DESC8", "
			 In case of delay, cancellation or other unforeseen circumstances, 
			 you are obligated to inform your driver (local operator) or in case 
			 of emergency our Call Centre +381646597200
	");
	
	$smarty->assign("SERVICES_DESC9", "
			In case that you have not received driver's contact 
			information by e-mail 24 hours before the transfer, please contact us.
	");


// translator
$smarty->assign("POLICIES", "Policies");
$smarty->assign("ENGLISH", "English");
$smarty->assign("RUSSIAN", "Russian");
$smarty->assign("FRENCH", "French");
$smarty->assign("GERMAN", "German");
$smarty->assign("ITALIAN", "Italian");
$smarty->assign("LEN", " (EN)");
$smarty->assign("LRU", " (RU)");
$smarty->assign("LFR", " (FR)");
$smarty->assign("LDE", " (DE)");
$smarty->assign("LIT", " (IT)");
$smarty->assign("COUNTRYNAME", "Country name");
$smarty->assign("COUNTRYDESC", "Country description");
$smarty->assign("PLACENAME", "Location name");

$smarty->assign("DRIVER_PRICE", "Driver Price");
$smarty->assign("PROVISIONPERC", "Provision %");

$smarty->assign("COUNTRYISO", "Country ISO");
$smarty->assign("COUNTRYCODE", "Country code");
$smarty->assign("COUNTRYCODE3", "Country code 3");
$smarty->assign("PHONEPREFIX", "Phone prefix");

// coupons
$smarty->assign("CODE", "Code");
$smarty->assign("VALIDFROM", "Valid From");
$smarty->assign("VALIDTO", "Valid To");
$smarty->assign("TRANSFERFROMDATE", "From Date");
$smarty->assign("TRANSFERTODATE", "To Date");
$smarty->assign("LIMITLOCATIONID", "Limit Location");
$smarty->assign("WEEKDAYSONLY", "Weekdays Only");
$smarty->assign("RETURNONLY", "Return Only");
$smarty->assign("TIMESUSED", "Times Used");

$smarty->assign("REFRESH_CACHE", "Refresh Cache");

// reviews
$smarty->assign("SURVEY", "Survey");
$smarty->assign("SEND_EMAIL_SURVEY", "Send Email Survey");
$smarty->assign("SURVEY_SENT", "Survey sent at");
$smarty->assign("ROUTE_REVIEWS", "Reviews");
$smarty->assign("ORDERID", "Order ID");
$smarty->assign("USEREMAIL", "User Email");
$smarty->assign("USERNAME", "User Name");
$smarty->assign("COMMENT", "Comment");
$smarty->assign("SCORESERVICE", "Score - Service");
$smarty->assign("SCOREDRIVER", "Score - Driver");
$smarty->assign("SCORECLEAN", "Score - Cleanliness");
$smarty->assign("SCOREVALUE", "Score - Value for money");
$smarty->assign("SCOREWEBSITE", "Score - Website");
$smarty->assign("SCORETOTAL", "Score - Total");
$smarty->assign("DRIVERONTIME", "Was driver on time");
$smarty->assign("RECOMMEND", "Would recommend");
$smarty->assign("BOOKAGAIN", "Would book again");
$smarty->assign("SURVEY_REPORT", "Survey - Report");
$smarty->assign("SHOW_REVIEWS", "Show results");
$smarty->assign("SURVEY_RESULTS_LIST", "Survey results - List");

$smarty->assign("EXTRA_SERVICES", "Extras Master");
$smarty->assign("ANY", "All");
$smarty->assign("ONLY_EXTRAS", "Only with extras");

$smarty->assign("PAY_CASH", "Cash");
$smarty->assign("PAY_INVOICE", "Bank transfer");
$smarty->assign("PAY_ONLINE", "Online");

// Josip Special Dates
$smarty->assign("SPECIALDATE", "Date");
$smarty->assign("SPECIALDATES", "Special Dates");
$smarty->assign("SPECIALTIMES", "Special Times");
$smarty->assign("STARTTIME", "Start Time");
$smarty->assign("ENDTIME", "End Time");
$smarty->assign("CORRECTIONPERCENT", "Percent");

//Company info - Leo
$smarty->assign("CO_NAME", "Company name");
$smarty->assign("CO_ADDRESS", "Company address");
$smarty->assign("CO_TEL", "Company phone");
$smarty->assign("CO_FAX", "Company fax");
$smarty->assign("CO_CITY", "Company city");
$smarty->assign("CO_COUNTRY", "Company country");
$smarty->assign("CO_ZIP", "Company ZIP Code");
$smarty->assign("CO_TAXNO", "Company tax number");
$smarty->assign("CO_BANK", "Company bank");
$smarty->assign("CO_ACCOUNTNO", "Company account number");
$smarty->assign("CO_IBAN", "Company IBAN");
$smarty->assign("CO_SWIFT", "Company SWIFT code");
$smarty->assign("CO_DOMESTICTAX", "Company domestic tax");
$smarty->assign("CO_FOREIGNTAX", "Company foreign tax");
$smarty->assign("CO_EURINFO", "Company EUR info");
$smarty->assign("CO_PAYMENTINFO", "Company payment info");
$smarty->assign("CO_FACEBOOK", "Facebook");
$smarty->assign("CO_TWITTER", "Twitter");
$smarty->assign("CO_LINKEDIN", "LinkedIn");
$smarty->assign("CO_YOUTUBE", "Youtube");
$smarty->assign("CO_GOOGLEPLUS", "Google+");
//Extra Services
$smarty->assign("ID", "Service ID");
$smarty->assign("DISPLAYORDER", "Service Display order");
$smarty->assign("SERVICEEN", "Extra service (EN)");
$smarty->assign("SERVICEDE", "Extra service (DE)");
$smarty->assign("SERVICERU", "Extra service (RU)");
$smarty->assign("SERVICEFR", "Extra service (FR)");
$smarty->assign("SERVICEIT", "Extra service (IT)");
$smarty->assign("SERVICESE", "Extra service (SE)");
$smarty->assign("SERVICENO", "Extra service (NO)");
$smarty->assign("SERVICEES", "Extra service (ES)");
$smarty->assign("SERVICENL", "Extra service (NL)");
$smarty->assign("LSE", " (SE)");
$smarty->assign("LNO", " (NO)");
$smarty->assign("LES", " (ES)");
$smarty->assign("LNL", " (NL)");
$smarty->assign("COUNTRYNAMERU", "Country name (RU)");
$smarty->assign("DESCRIPTIONSE", "Description (SE)");
$smarty->assign("DESCRIPTIONNO", "Description (NO)");
$smarty->assign("DESCRIPTIONES", "Description (ES)");
$smarty->assign("DESCRIPTIONNL", "Description (NL)");
$smarty->assign("SUBDRIVER_HISTORY", "Subdriver History");
$smarty->assign("AGENT_TRANSFERS", "Agent transfers");
$smarty->assign("DEPOSIT", "Deposit (EUR)");*/