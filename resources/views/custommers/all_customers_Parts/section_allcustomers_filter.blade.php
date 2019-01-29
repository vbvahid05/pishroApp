@section('section_allcustomers_filter')
<table class="table">
  <tr>
    <td style="width:  2px;"></td>
    <td style="width:  300px;">
      <div class="filters ui search">
      <div class="ui icon input">
        <?php //placeholder="{{ Lang::get('labels.search') }}" ?>
        <input ng-model="search.$" class="prompt" type="text"  ng-keypress="changePagin(10000)" ng-blur="changePagin(10)">
        <i class="search icon"></i>
      </div>
        <div class="results"></div>
      </div>
    </td>
    <td></td>
    <td>

    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
@endsection
