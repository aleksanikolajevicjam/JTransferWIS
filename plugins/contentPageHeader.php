                    <h1>
                        <? 
                        	$pageTitle = str_replace('_', ' ', $activePage);
                        	echo ucfirst($pageTitle);
                        ?>
                        
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?echo ucfirst($pageTitle);?></li>
                    </ol>
