<a href="#" id="seenotifications" value="1" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell"></i>
        <span class="notifcount hidden"></span>    
</a>
                    <ul class="dropdown-menu message-dropdown">
                         <li class="message-header">
                            Notifications
                        </li>
                        <li id="message-preview" class="message-preview">
                            
                        </li>                        
                        <li class="message-footer">
                            <a href="{{ action("SMSController@viewAllNotifications") }}" class="text-center">View all Notifications</a>
                        </li>
                    </ul>