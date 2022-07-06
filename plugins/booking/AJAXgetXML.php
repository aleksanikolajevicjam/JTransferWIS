<?php
		$xml = simplexml_load_file($_FILES['ufile']['tmp_name']);      
		
		$transfer_arr=array();
		
		$transfer_arr['ReferenceNo']= html_entity_decode($xml->reference);
		
		$time=html_entity_decode($xml->transfers->transfer[0]->origin->pickup_time);
		$time=explode(' ',$time);
		$transfer_arr['transferDate']=$time[0];
		$transfer_arr['transferTime']=$time[1];
		
		$transfer_arr['FromName']=html_entity_decode($xml->transfers->transfer[0]->origin->name); 
		$transfer_arr['ToName2']=html_entity_decode($xml->transfers->transfer[0]->destination->name);
		$transfer_arr['PaxNo2']=html_entity_decode($xml->transfers->transfer[0]->passengers->total_passengers);
		$transfer_arr['VehicleName2']=html_entity_decode($xml->transfers->transfer[0]->vehicle->title);
		$transfer_arr['PaxFirstName']=html_entity_decode($xml->lead_passenger->name);
		$transfer_arr['PaxSurName']=html_entity_decode($xml->lead_passenger->surname);
		$transfer_arr['PaxTel']=html_entity_decode($xml->lead_passenger->mobile);
		$transfer_arr['PaxEmail']=html_entity_decode($xml->lead_passenger->email);
		$transfer_arr['FlightNo']=html_entity_decode($xml->transfers->transfer[0]->origin->flight->flight_number);
		$transfer_arr['FlightCo']=html_entity_decode($xml->transfers->transfer[0]->origin->flight->airline); 
		$ftime=html_entity_decode($xml->transfers->transfer[0]->origin->flight->date);
		$ftime=explode(' ',$ftime);
		$transfer_arr['FlightTime']=$ftime[1]; 
		
		$transfer_arr['DFlightNo']=html_entity_decode($xml->transfers->transfer[0]->destination->flight->flight_number);
		$transfer_arr['DFlightCo']=html_entity_decode($xml->transfers->transfer[0]->destination->flight->airline); 
		$dftime=html_entity_decode($xml->transfers->transfer[0]->destination->flight->date);
		$dftime=explode(' ',$dftime);
		$transfer_arr['DFlightTime']=$dftime[1]; 
		
		$transfer_arr['SPAddressHotel']=html_entity_decode($xml->transfers->transfer[0]->origin->name); 
		$transfer_arr['SDAddressHotel']=html_entity_decode($xml->transfers->transfer[0]->destination->accommodation->name); 
		$transfer_arr['PickupAddress']=html_entity_decode($xml->transfers->transfer[0]->origin->address); 
		$transfer_arr['DropAddress']=html_entity_decode($xml->transfers->transfer[0]->destination->accommodation->address); 		
		
		// povratni transfer
		$time=html_entity_decode($xml->transfers->transfer[1]->origin->pickup_time);
		$time=explode(' ',$time);
		$transfer_arr['returnDate']=$time[0]; 
		$transfer_arr['returnTime']=$time[1];
		
		$transfer_arr['RFlightNo']=html_entity_decode($xml->transfers->transfer[1]->origin->flight->flight_number);
		$transfer_arr['RFlightCo']=html_entity_decode($xml->transfers->transfer[1]->origin->flight->airline); 
		$ftime=html_entity_decode($xml->transfers->transfer[1]->origin->flight->date); 
		$ftime=explode(' ',$ftime); 
		$transfer_arr['RFlightTime']=$ftime[1];
		
		$transfer_arr['RDFlightNo']=html_entity_decode($xml->transfers->transfer[1]->destination->flight->flight_number);
		$transfer_arr['RDFlightCo']=html_entity_decode($xml->transfers->transfer[1]->destination->flight->airline); 
		$dftime=html_entity_decode($xml->transfers->transfer[1]->destination->flight->date);
		$dftime=explode(' ',$dftime);
		$transfer_arr['RDFlightTime']=$dftime[1]; 
		
		$transfer_arr['RPAddressHotel']=html_entity_decode($xml->transfers->transfer[1]->origin->name); 
		$transfer_arr['RDAddressHotel']=html_entity_decode($xml->transfers->transfer[1]->destination->accommodation->name); 
		$transfer_arr['RPickupAddress']=html_entity_decode($xml->transfers->transfer[1]->origin->address); 
		$transfer_arr['RDropAddress']=html_entity_decode($xml->transfers->transfer[1]->destination->accommodation->address); 		
		
	 
		echo json_encode($transfer_arr);
		

?>