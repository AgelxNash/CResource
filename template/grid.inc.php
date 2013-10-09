<link rel="stylesheet" type="text/css" href="<?=$dir;?>easyui/themes/bootstrap/easyui.css">
<link rel="stylesheet" type="text/css" href="<?=$dir;?>easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?=$dir;?>easyui/demo/demo.css">
<script type="text/javascript" src="<?=$dir;?>easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?=$dir;?>easyui/plugins/jquery.edatagrid.js"></script>
<style>
    .datagrid-cell
    {
        color:#000;
    }
</style>
@TODO: Проверка на соответствие шаблона<br />
@TODO: Поиск документа по данным LIKE<br />
@TODO: Плагином вырезать кнопки управления документом и подменить их на обычную сохранить с продолжением редактирования<br />

<div id="tt" class="easyui-tabs" style="height:auto;">
    <div title="Document" style="padding:10px" data-options="closable:false" >
        <table class="easyui-datagrid" id="dataGrid" title="Basic DataGrid"
               data-options="idField:'<?=$idField;?>',toolbar:'#tbar',singleSelect:true,pagination:true">
            <thead>
            <tr>
                <?=$header;?>
            </tr>
            </thead>
        </table>
    </div>

</div>

<div id="tbar" style="padding:5px;height:auto">
    <div style="margin-bottom:5px">
        <a href="#" class="easyui-linkbutton" onclick="addBtn()" iconCls="icon-add" plain="true"> Добавить</a>
        <a href="#" class="easyui-linkbutton" onclick="editBtn()" iconCls="icon-edit" plain="true"> Редактировать</a>
        <a href="#" class="easyui-linkbutton"  iconCls="icon-remove" plain="true" onclick="javascript:<?=$jqname;?>('#dataGrid').edatagrid('destroyRow')"> Удалить</a>
        <span style="margin-left:20px";>&nbsp;</span>
        <input class="textsearch" style="width:180px">
        <a href="#" class="easyui-linkbutton" onclick="findBtn()" iconCls="icon-search">Найти</a>
    </div>
</div>

<script type="text/javascript">
    var index = 0;
    function addPanel(id){
        index++;
        var url = window.location.href.replace(/#[^#]*$/, "");
        if(id>0){
            title = 'Документ #' + id;
            url = '<?=$docEditURL;?>' + id;
        }else{
            title = 'Новый документ';
            url = '<?=$docNewURL;?>';
        }
        <?=$jqname;?>('#tt').tabs('add',{
            title: title,
            content: '<iframe scrolling="yes" frameborder="0"  src="'+ url +'" style="width:100%;height:500px"></iframe>',
            height: '500px',
            closable: true
        });
    }
    function removePanel(){
        var tab = <?=$jqname;?>('#tt').tabs('getSelected');
        if (tab){
            var index = <?=$jqname;?>('#tt').tabs('getTabIndex', tab);
            <?=$jqname;?>('#tt').tabs('close', index);
        }
    }

    var pager = <?=$jqname;?>('#dataGrid').datagrid().datagrid('getPager');
    var editIndex = undefined;
    <?=$jqname;?>('#dataGrid').edatagrid({
            url: '<?=$listURL;?>',
            saveUrl: '<?=$saveURL;?>',
            updateUrl: '<?=$updateURL;?>',
            destroyUrl: '<?=$delURL;?>',
            errorMSG:{
                title:"Ошибка"
            },
            destroyMsg:{
                norecord:{
                    title:'Ошибка',
                    msg:'Необходимо выбрать запись для удаления'
                },
                confirm:{
                    title:'Подтверждение удаления',
                    msg:'Вы действительно хотите удалить запись?'
                }
            },
            onSave: function(index, row){
                <?=$jqname;?>(this).datagrid('reload');
            }
        });

    function addBtn(){
        addPanel(0);
    }
    function delBtn(){
        alert('Тут нужно удалить строку');

    }
    function editBtn(){
        var row = <?=$jqname;?>('#dataGrid').datagrid('getSelected');
        if (row){
            addPanel(row.<?=$idField;?>);
        }else{
            <?=$jqname;?>.messager.show({
                title: "Ошибка",
                msg: "Необходимо выбрать документ для редактирования"
            });
        }
    }

    function findBtn(){
        alert('Запустить поиск LIKE');
    }
</script>

