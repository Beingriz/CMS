<div class="right-menu">
    <p class="heading2">Insight</p>
    <div class="right-menu-section">
        <img src="./photo_gallery\insight.jpg" alt="" >
        <div class="sec-data">
            <p class="section-heading">Applications Served</p>
            <p class="section-value">Total {{$applications_served}}</p>
            <p class="section-pre-values">Yesterday {{$previous_day_app}}</p>
        </div>
    </div>
    <div class="right-menu-section">
        <img src="./photo_gallery\insight.jpg" alt="" >
        <div class="sec-data">
            <p class="section-heading">Applications Deliverd</p>
            <p class="section-value">Delivered : {{$applications_delivered}}</p>
            <p class="section-pre-values">Yesterday {{$previous_day_app_delivered}}</p>
        </div>
    </div>
    <div class="right-menu-section">
        <img src="./photo_gallery\insight.jpg" alt="" >
        <div class="sec-data">
            <p class="section-heading">Revenue Generated</p>
            <p class="section-value">Gross &#x20B9; {{$total_revenue}}/-</p>
            <p class="section-pre-values">Yesterday &#x20B9; <span>{{$previous_revenue}}</span></p>
        </div>
    </div>
    <div class="right-menu-section">
        <img src="./photo_gallery\insight.jpg" alt="" >
        <div class="sec-data">
            <p class="section-heading">Balance Due Amount</p>
            <a class="section-value" href="{{url('balance_list')}}">Gross Bal: &#x20B9; {{$balance_due}}/-</a>
            <a class="section-pre-values" href="#">Yesterday &#x20B9; <span>{{$previous_bal}}</span></a>
        </div>
    </div>
</div>
