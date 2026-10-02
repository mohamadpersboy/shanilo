<ul class="step no_bullet">
    <li class="item"><label>
            <div class="table_style2">
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <select data-url="{{route('front.profile.shop.get-covered-cities-list',$shop)}}"
                                    name="state" width="100" id="select-shop-cities">
                                <option value="">انتخاب استان</option>
                                @foreach($states as $index=>$state)
                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </label>
    </li>
</ul>