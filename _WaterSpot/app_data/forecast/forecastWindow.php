<?php echo '

    <h2 style="text-align:center;" id="spotName"></h2>

    <ul class="nav nav-tabs mx-auto" role="tablist" style="min-width:50%">
      <li class="nav-item" style="width:20%">
        <a class="nav-link active" data-toggle="tab" href="#Day1Panel" role="tab" id="DayTab1"></a>
      </li>
      <li class="nav-item" style="width:20%">
        <a class="nav-link" data-toggle="tab" href="#Day2Panel" role="tab" id="DayTab2"></a>
      </li>
      <li class="nav-item" style="width:20%">
        <a class="nav-link" data-toggle="tab" href="#Day3Panel" role="tab" id="DayTab3"></a>
      </li>
      <li class="nav-item" style="width:20%">
        <a class="nav-link" data-toggle="tab" href="#Day4Panel" role="tab" id="DayTab4"></a>
      </li>
      <li class="nav-item" style="width:20%">
        <a class="nav-link" data-toggle="tab" href="#Day5Panel" role="tab" id="DayTab5"></a>
      </li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active forecastPanel"   id="Day1Panel" role="tabpanel">
        <div class="forecastDay" id="Day1"></div>
      </div>

      <div class="tab-pane forecastPanel"  id="Day2Panel" role="tabpanel">
        <div class="forecastDay" id="Day2"></div>
      </div>

      <div class="tab-pane forecastPanel"  id="Day3Panel" role="tabpanel">
        <div class="forecastDay" id="Day3"></div>
      </div>

      <div class="tab-pane forecastPanel"  id="Day4Panel" role="tabpanel">
        <div class="forecastDay" id="Day4"></div>
      </div>

      <div class="tab-pane forecastPanel"  id="Day5Panel" role="tabpanel">
        <div class="forecastDay" id="Day5"></div>
      </div>

    </div>
    '; ?>
