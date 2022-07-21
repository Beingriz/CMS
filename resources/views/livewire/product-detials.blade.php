<div>
    <div class="box">
        <div class="pdct-name-header">
            <div class="pdct-h-bar">
                <p  class="pdct-main-name">{{$Name}}</p>
                <div class="p-v-desc">
                    <p>{{$Description}}</p>
                </div>
            </div>
            <div class="pdct-v-image">
                <img src="../{{$Thumbnail}}" alt="">
            </div>
        </div>
        <div class="pdct-v-desc">
            <div class="descriptions">
                <div class="heading2">
                   <p >About {{$Name}}</p>
                </div>
                <p  class="pdct-des">Detils</p>
                <p class="p-v-desc">{{$Details}}</p>
                <p  class="pdct-des">Features</p>
                <p class="p-v-desc">{{$Features}}</p>
                <p  class="pdct-des">Specificaton</p>
                <p class="p-v-desc">{{$Specification}}</p>
            </div>
            <div class="p-v-details">

                <p>Total services Availed</p>
                <p>Due Time for Service</p>
                <p>Total services Availed</p>
                <p>Total services Availed</p>
            </div>
        </div>
        <div class="data-table-header">
            <p class="heading"> Services offerd for  {{$Name}} </p>
        </div>
        <section class="v-products">
            <!-- product name , image, detiils, and corresponding webpage links  -->
            @foreach($services as $service)
            <a id="" class="v-product" href="#" wire:click.prevent="ShowDetails('{{$service->Id}}')">

                <!-- Product Details -->
                <div class="pdct-v-heading">
                    <p class="pdct-title">
                        {{$service->Name}}
                    </p>
                </div>
                <div class="sec-middle">
                    <div class="pdct-image">
                        <img src="../{{$service->Thumbnail}}" alt="Product Image">
                    </div>
                    <div class="pdct-info">
                        <p> {{$service->Total_Count}}+ Services Delivered</p>
                    </div>
                </div>

            </a><!-- Product Details End-->
            @endforeach
        </section>

        @if (count($Document_List)>0)
            <div class="pdct-name-header">
                <div class="pdct-h-bar">
                    <p  class="pdct-main-name">{{$Sub_Name}}</p>
                    <div class="p-v-desc">
                        <p>{{$Sub_Desc}}</p>
                    </div>
                </div>
                <div class="pdct-v-image">
                    <img src="../{{$Thumbnail}}" alt="">
                </div>
            </div>
            <p class="heading2">List of Supporting Documents Required for {{$Sub_Name}}</p>
        <div class="document-list">
            <div class="doc-list">
                <table>
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Supporting Document Name</th>
                            <th>Icon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Document_List as $item)
                        <tr>
                            <td style="width:10%">
                                {{ $n++ }}
                            </td>
                            <td style="width:20%">{{$item['Name']}}</td>
                            <td style="width:10%">{{$item['Thumbnail']}}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-v-details">
                <p>{{$Sub_Total_Count}}</p>
            </div>
        </div>
    </div>
    @endif
    <div class="clear"></div>
</div>
