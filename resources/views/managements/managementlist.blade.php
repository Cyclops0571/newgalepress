@layout('layouts.master')

@section('content')
    {{ Html::script('js/managements.js?v=' . APP_VER) }}
    <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
        <div class="block block-drop-shadow">
            <div class="header">
                <h2>Server Yönetimi</h2>
            </div>
            <div class="content controls">
                <?php echo Form::open(__('route.managements_save'), 'POST'); ?>
                <?php echo Form::token(); ?>
                <div class="form-row">
                    <div class="col-md-4">
                        <input type="button" class="btn-info" value="{{__('common.import_languages')}}" onclick="cManagement.importLanguagesToDb();"/>
                        <input type="button" class="btn-success" value="{{__('common.export_languages')}}" onclick="cManagement.exportLanguagesFromDB();"/>
                    </div>
                </div>
                <?php echo Form::close(); ?>
                <div class="form-row">
                    <div class="col-md-12">
                        <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Müşteri ID</th>
                                <th scope="col">Müşteri Adı</th>
                                <th scope="col">Kapladığı Alan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <form id="contentOrderForm">
                                @foreach($rows as $size => $customer)
                                    <tr class="{{ Common::htmlOddEven() }}">
                                        <td>{{$customer->CustomerID}}</td>
                                        <td>{{$customer->CustomerName}}</td>
                                        <td>{{$size}}</td>
                                    </tr>
                                @endforeach
                            </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection