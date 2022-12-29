 <script type="text/javascript">
     
     
 function toTimeZoneHouradd(time, zone,minutes,timechange = 0,timechangeamerice = 0,timechangeeurope = 0) {
        var format = 'YYYY/MM/DD HH:mm:ss A';
        var format2 = 'YYYY/MM/DD hh:mm a';
          let checktimezoneexist  = zone;
            let timezoneexist  = "America"
            let timezoneexist2  = "Europe"

            // console.log('timetimetimetime',)
            
        
        if(timechange == 0){
          
            if(checktimezoneexist.includes(timezoneexist)){
                console.log('America exist');
                
                     timezoneexist = "Phoenix"
                if(checktimezoneexist.includes(timezoneexist)){
                    //  console.log('exist Phoenix');
                    
                     minutes  = minutes - 60;
                    
                }else{
                     minutes  = minutes - 60;
                }
                
               
            }
            else if(checktimezoneexist.includes(timezoneexist2)){
                console.log('Europe exist');
                timezoneexist2 = "London"
                // if(checktimezoneexist.includes(timezoneexist2)){
                //      console.log('exist London');
                // }else{
                     minutes  = minutes - 60;
                // }
            }
            
        }else{
            
            if(timechangeamerice ==  0){
                  if(checktimezoneexist.includes(timezoneexist)){
                console.log('America exist');
                
                     timezoneexist = "Phoenix"
                if(checktimezoneexist.includes(timezoneexist)){
                     console.log('exist Phoenix');
                     
                      minutes  = minutes - 60;
                     
                }else{
                     minutes  = minutes - 60;
                }
                
               
            }
            }
            
            if(timechangeeurope == 0){
                 if(checktimezoneexist.includes(timezoneexist2)){
                console.log('Europe exist');
                timezoneexist2 = "London"
                // if(checktimezoneexist.includes(timezoneexist2)){
                //      console.log('exist London');
                // }else{
                     minutes  = minutes - 60;
                // }
            }
            }
            
            
            
        }    
            
            
            

            if (minutes > 0) {
                return moment(time, format).tz(zone).add(minutes, 'minutes').format(format2);
            }else{
            

                minutes = Math.abs(minutes)
                return moment(time, format).tz(zone).subtract(minutes, 'minutes').format(format2);
            }
      

        // return moment.tz(time,zone).format('YYYY-MM-DD HH:mm:ss');
    }
     
     
 </script>