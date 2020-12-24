        <?php /* Common script to all page. Must include head.php at the top */       ?>

        <script type="text/javascript" src="<?php asset('js/0e537d0987cea355e9484c0f496ebf75f8ba7e9f40e67cfa14c9c9b3587e29c3.js');?>"></script>
        <script type="text/javascript" src="<?php asset('js/uikit.min.js');?>"></script>
        <script type="text/javascript" src="<?php asset('js/uikit-icons.min.js');?>"></script>
        <script type="text/javascript" src="<?php asset('js/jquery-3.3.1.min.js');?>"></script>
            
        <?php
            // Add script
            if(isset($script)):
                foreach ($script AS $src): 
        ?>
            <script type="text/javascript" src="<?php asset($src);?>"></script>
        <?php
                endforeach;
            endif;
        ?>

        <script>
            const REQUEST = '<?php url('api/v1/json'); ?>';
            const APP = {
                letNumber : (() => {
                    $('.number').each(function (e) {
                        $(this).on('keyup', function (e) {
                            let val = $(this).val();if(isNaN(val)){
                                val = val.replace(/[^0-9\.]/g,'');
                                if(val.split('.').length>2){
                                    val =val.replace(/\.+$/,"");
                                }
                            }
                            this.value = val;
                        })
                    })
                }),

                alert : ((msg='Unable to handle the process', type=false) => {
                    let pos = "top-center";
                    type = (type)?'primary':'danger'
                    if(window.innerWidth <= 480){
                        pos = "bottom-center";
                    }
                    UIkit.notification({message: msg,status: type,pos: pos,timeout: 5000});
                }),

                toConvert: ((datepicker, ele)=>{
                    if(ele.is){
                        datepicker.changeDateMode();
                        $(ele.to).val(datepicker.getDate().getDateString());
                        datepicker.changeDateMode();
                    }
                    return;
                }),

                datePicker: ((ele = '.datepicker', ap = true) => {
                    $(ele).each(function(){
                        let picker = $(this);
                        let datepicker = new Calendar({
                                isHijriMode: true,
                                isAutoSelectedDate: true
                            });
                        let convert = {
                            is: !($(this).attr('data-to') == undefined),
                            to: $(this).attr('data-to')
                        }

                        $(this).parent().append(datepicker.getElement());

                        if(ap){
                            picker.val(datepicker.getDate().getDateString());
                            APP.toConvert(datepicker, convert);
                        };
                        picker.on('focus', function(){
                            datepicker.show();
                        });

                        datepicker.callback = function() {
                            picker.val(datepicker.getDate().getDateString());
                            picker.selectionStart = 0;
                            picker.selectionEnd = picker.val().length;
                        };

                        datepicker.onHide = function() {
                            APP.toConvert(datepicker, convert);
                        };
                    })
                }),

                navActive: ((a=null)=>{
                    $('.uk-nav a').each(function(e){
                        e = $(this);
                        a = (e.attr('href') == (location.href));
                        if($(this).hasClass('lactive')){
                            e.removeClass("lactive")
                        }else{
                            (a)?e.addClass('lactive'):'';
                        }
                    })
                }),

                submit: ((ele)=>{
                    ele = ele.find('[type=submit]');
                    ele.attr('disabled', 'disabled').attr('data-pre', ele.text()).addClass('nrs_').html('<div role="status"><div uk-spinner></div><span class="uk-margin-left">validating...</span></div>');
                }),

                resetSubmit: (()=>{
                    $('.nrs_').each(function(){
                        $(this).removeAttr('disabled').removeClass('nrs_').html($(this).data('pre'));
                    })
                }),

                script: ((script)=>{
                    let s = document.createElement( 'script' );
                    s.setAttribute( 'src', script );
                    return document.head.appendChild( s );
                }),

                css: ((css)=>{
                    let s = document.createElement( 'link' );
                    s.setAttribute( 'href', css );
                    return document.head.appendChild( s );
                }),

                api: ((param, callback, method='POST')=>{
                    param = {
                        request: param,
                        method : method,
                        time: Date.now(),
                        <?php echo CSRF_KEY; ?>: document.querySelector('meta[name=csrf]').getAttribute('content')
                    };

                    $.ajax({
                        url:REQUEST,
                        method:method,
                        data: param,
                        crossDomain: false,
                        dataType:'JSON',
                        success: ((response, status, code)=>{
                            callback(response)
                        }),
                        error: ((response, status, code)=>{
                            console.warn(response, status, code);
                        })
                    })
                }),

            };
            APP.navActive();
        </script>
        <?php if( \App\Controllers\Auth\Auth::isLoggedIn()): ?>
            <script>
                const init = (()=>{
                    $(document).on('click', '.drop', function(e){
                        // DROP ENTRIES
                        e.preventDefault();
                        const t = {
                            a: $(this).attr('data-api'),
                            k: $(this).attr('data-drop')
                        };
                        
                        if(t.a != undefined && t.k != undefined ){
                            e = 'd'+Date.now();

                            let form = '<div><form id="'+e+'" action="<?php url('delete');?>" method="post"> <input type="hidden" name="<?php echo CSRF_KEY; ?>" value="'+document.querySelector('meta[name=csrf]').getAttribute('content')+'"><input type="hidden" name="api" value="'+t.a+'"><input type="hidden" name="key[]" value="'+t.k+'"></form></div>';
                            
                            UIkit.modal.confirm('<div class="uk-alert uk uk-alert-danger uk-width-1 uk-box-shadow-small"><strong>Warning :</strong> Deleting a record will also delete all its related records.</div>').then(function() {
                                $('body').append(form);
                                $('#'+e).submit();
                            }, function () {
                                console.log('Rejected.');
                            });
                        }
                    })

                    $('._le').on('click', function(e){
                        // Load ledger entries
                        e.preventDefault();
                        $this = $(this);
                        if($this.attr('data-filter') != undefined && $this.attr('data-out') != undefined){
                            let out = $this.attr('data-out').split('>');
                            $(out).html('<div class="uk-text-center" role="status"><div uk-spinner></div></div>');
                            if(out.length == 2){
                                APP.api({
                                    input: {
                                        f: 'entry',
                                        k: $this.attr('data-filter'),
                                    },
                                    endpoint: 'filterX'
                                }, function (data) {
                                    let t = '';
                                    $this.off();
                                    if (data.s) {
                                        t = "<table id='table' class='uk-table uk-table-middle uk-table-divider'><thead><tr>"; 

                                        for (let i = 0; i < data.th.length; i++) {
                                            t += '<th>'+data.th[i]+'</th>';
                                        }
                                        t += '</tr></thead><tbody>';
                                        if(data.m.length > 0){
                                            data.m.forEach(tr => {
                                                t += '<tr>';
                                                for(let td in tr){
                                                    t += '<td>'+tr[td]+'</td>';
                                                }
                                                t += '</tr>';
                                            });
                                        }else{
                                            t += '<tr><td class="uk-text-center" colspan="'+data.th.length+'">No records found</td></tr>';
                                        }
                                        t += '</tbody></table>';
                                    } else {
                                        t = '<div class="uk-alert-warning uk-box-shadow-small" uk-alert><p>'+data.m+'.</p></div>';
                                    }
                                    let i = '_l'+Date.now();
                                    let d = document.createElement(out[1]);
                                    $(d).attr('id', i).addClass('uk-overflow-auto uk-active').appendTo(out[0]);
                                    $(out[0]+' > #'+ i).html(t);
                                    
                                })
                            }else{
                                APP.alert('Somthing went wrong');
                            }
                        }
                    })
                })()
            </script>
        <?php endif; ?>

    </body>
</html>