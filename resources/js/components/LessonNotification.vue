<template>


                                <div class="scrollable-content
                                    scrollable-slim-box">
                                    <ul class="no-border notifications-box">
                                        <li v-for="lesson in lessons" >
                                       <a :href="lesson.data['lesson'][0]['anchorroute']">  <span class="bg-danger
                                                icon-notification glyph-icon
                                                icon-bullhorn"></span>
                                            <span class="notification-text">  {{lesson.data['lesson'][0]['title']}}</span>
                                            <div class="notification-time">
                                                a few seconds ago
                                                <span class="glyph-icon
                                                    icon-clock-o"></span>
                                            </div>
                                            </a>
                                        </li>
                                       
                                    </ul>
                                </div>
                             

  
</template>

<script>
    export default {
       props:["lessons"]
    }
</script>
