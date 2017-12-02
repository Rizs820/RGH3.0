    <div class="container-fluid">
            <div class="block-header">
                <h2>BOOKING MANAGER (BM) / MANAGE BOOKING (M)</h2>
            </div>    
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                VIEW / CANCEL BOOKINGS
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="./?act=home">Back to Home</a></li>
                                        <li><a href="#" onclick='location.reload(true); return false;'>Reset/Reload</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Guide</th>
                                        <th>Booking Time</th>
                                        <th>Confirmed</th>
                                        <th>Cancel</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Guide</th>
                                        <th>Booking Time</th>
                                        <th>Confirmed</th>
                                        <th>Cancel</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        $query = "SELECT guide,book_time,confirmed,uid FROM booking ORDER BY uid";
                                        $stmt = $mysqli->stmt_init();
                                        if(!$stmt->prepare($query))
                                        {
                                            print "No Data Available or Data Fetch Error, Contact Admin!!!\n";
                                        }
                                        else
                                        {
                                            //$stmt->bind_param("s", $continent);
                                            $stmt->execute();
                                            $stmt->bind_result($guide,$book_time,$confirmed,$uid);
                                            //$stmt->fetch();
                                            //$result = $stmt->get_result();
                                            //while ($row = $result->fetch_array(MYSQLI_NUM))
                                            while ($stmt->fetch())
                                            {
                                                echo '<tr>';
                                                echo '<td>'.$guide.'</td>';
                                                echo '<td>'.$book_time.'</td>';
                                                echo '<td>'.$confirmed.'</td>';
                                                echo '<td><form method="POST"><input type="hidden" id="drequest_opr'.$uid.'" value="Delete_Book"><input type="hidden" id="drequest_id'.$uid.'" name="request_id" value="'.UUID::v4().'"><input type="hidden" id="duid_val'.$uid.'" name="uid_val" value="'.$uid.'"><button type="submit" class="btn bg-red waves-effect" id="Delete_Action" name="Delete_Action" value="'.$uid.'"><i class="material-icons ">delete_forever</i></button></form></td>';
                                                echo '</tr>';
            
                                            }
                                        }
                                        $stmt->close();
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
    </div>
    
