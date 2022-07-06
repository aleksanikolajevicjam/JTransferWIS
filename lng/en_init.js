// VARIABLES AVAILABLE TO ALL FUNCTIONS
var statusDescription = {};
statusDescription[1] = 'Active';
statusDescription[2] = 'Changed';
statusDescription[3] = 'Cancelled';
statusDescription[4] = 'TEMP';
statusDescription[5] = 'Completed';

var userLevels = {};
userLevels[2] = 'Agent';
userLevels[3] = 'Client';
userLevels[4] = 'Affiliate';
userLevels[5] = 'iFrame User';
userLevels[6] = 'API User';
userLevels[12] = 'Taxi Site';
userLevels[31] = 'Driver';
userLevels[32] = 'Subdriver';
userLevels[41] = 'Operator';
userLevels[42] = 'Translator';
userLevels[43] = 'Routes Administrator';
userLevels[44] = 'Accountant';
userLevels[45] = 'Dispatcher';
userLevels[91] = 'Admin';
userLevels[99] = 'System Administrator';

var languages = {};
languages['en'] = 'English';
languages['ru'] = 'Rусский';
languages['de'] = 'Deutsche';
languages['it'] = 'Italiano';
languages['fr'] = 'Français';
languages['se'] = 'Svenska';
languages['no'] = 'Norsk';
languages['es'] = 'Español';
languages['nl'] = 'Nederlands';

var yesNo = {};
yesNo[0] = 'No';
yesNo[1] = 'Yes';

// payment Status
var paymentStatus = {};
paymentStatus [0] = 	'Not Paid';
paymentStatus [1] = 	'Bank transfer Sent';
paymentStatus [2] = 	'Warning sent';	
paymentStatus [3] = 	'Sued';
paymentStatus [4] =  	'Refunded';
paymentStatus [10] = 	'Lost - will not be paid';
paymentStatus [91] = 	'Compensated';
paymentStatus [99] = 	'Paid';

var paymentMethod = {};
paymentMethod[0] =  'Undefined';
paymentMethod[1] = 	'Online';
paymentMethod[2] = 	'Cash';
paymentMethod[3] = 	'Online and Cash';
paymentMethod[4] = 	'Bank transfer';
paymentMethod[5] = 	'Compensation';
paymentMethod[6] = 	'Bank transfer 2';
paymentMethod[9] = 	'Other';

var documentType = {};
documentType[0] =  'Choose type';
documentType[1] = 	'Proforma',
documentType[2] = 	'Prepayment Invoice',
documentType[3] = 	'Invoice',
documentType[4] = 	'Invoice Item'
documentType[5] = 	'Cancellation Invoice',
documentType[6] = 	'Credit Note';

var changeTransferReason = {};
changeTransferReason[0] =  'Pax FirstLast Name';
changeTransferReason[1] =  'Pax Phone';
changeTransferReason[2] =  'Pax Email';
changeTransferReason[3] =  'Pickup Date';
changeTransferReason[4] =  'Pickup Time';
changeTransferReason[5] =  'Flight Time';
changeTransferReason[6] =  'Flight Number';
changeTransferReason[7] =  'Pickup Address';
changeTransferReason[8] =  'Drop-Off Address';
changeTransferReason[9] =  'Pax Number';
changeTransferReason[10] =  'Payment method';
changeTransferReason[11] =  'Drivers Price';
changeTransferReason[12] =  'Extras';
changeTransferReason[13] =  'Pickup Notes';
changeTransferReason[14] =  'Message';

var driverConfStatus = {};
driverConfStatus[0] = 'No driver';
driverConfStatus[1] = 'Not Confirmed';
driverConfStatus[2] = 'Confirmed';
driverConfStatus[3] = 'Ready';
driverConfStatus[4] = 'Declined';
driverConfStatus[5] = 'No-show';
driverConfStatus[6] = 'Driver error';
driverConfStatus[7] = 'Completed';
driverConfStatus[8] = 'Operator Error';
driverConfStatus[9] = 'Dispatcher Error';
driverConfStatus[10] = 'Agent Error';
driverConfStatus[11] = 'Force majeure';
driverConfStatus[12] = 'Pending';	

var driverConfClass = {};
driverConfClass[0] = 'badge bg-red';
driverConfClass[1] = 'badge bg-red';
driverConfClass[2] = 'badge bg-blue';
driverConfClass[3] = 'badge bg-green';
driverConfClass[4] = 'badge bg-red';
driverConfClass[5] = '';
driverConfClass[6] = '';
driverConfClass[7] = '';

var driverPayment = {};
driverPayment[0] = 'Not paid';
driverPayment[1] = 'Partly paid';
driverPayment[2] = 'Paid';
driverPayment[3] = 'Compensated';

var vehicleClass = {};
vehicleClass[1] = 'Sedan';
vehicleClass[2] = 'Mini-van';
vehicleClass[3] = 'Mini-bus';
vehicleClass[4] = 'Mini-bus';
vehicleClass[5] = 'Bus';
vehicleClass[6] = 'Bus';

/* survey */
var bookAgain = {};
bookAgain[1] = 'No';
bookAgain[2] = 'Maybe';
bookAgain[3] = 'Yes';

var recommend = {};
recommend[1] = "I wouldn't feel comfortable recommending JamTransfer";
recommend[2] = 'I would recommend JamTransfer if asked';
recommend[3] = 'I would go out of my way to recommend JamTransfer';

var approved = {};
approved[0] = 'Not approved';
approved[1] = 'Approved';
approved[2] = 'Discarded';

var scores = {};
scores[2] = 2;
scores[4] = 4;
scores[6] = 6;
scores[8] = 8;
scores[10] = 10;