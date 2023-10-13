<x-app>
    <div class="row">
        <div class="col-md-7">
            <div class="box box-bordered">
                <div class="box-title"><h3><i class="fa fa-th-list"></i>Enviar e-mail:</h3></div>
                <div class="box-content nopadding">
                    <form  method="POST" action="{{route('email')}}" class='form-horizontal form-striped'>
                        @csrf
                        <div class="form-group">
                            <label for="textfield" class="control-label col-sm-2">Destinatário(s):</label>
                            <div class="col-sm-10">
                                <select name="recipients[]" id="recipients" multiple="multiple" class="chosen-select form-control" data-placeholder="Selecione um ou mais e-mails">
                                    @foreach ($users as $user)
                                        <option value="{{$user['email']}}">{{$user['email']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="control-label col-sm-2">Assunto:</label>
                            <div class="col-sm-10">
                                <input type="text" name="subject" id="subject" placeholder="Assunto do e-mail" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="textarea" class="control-label col-sm-2">Mensagem:</label>
                            <div class="col-sm-10">
                                <textarea name="body" id="body" rows="5" class="form-control" placeholder="Digite sua mensagem..."></textarea>
                            </div>
                        </div>
                        <div class="form-actions col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <table cellspacing="0" cellpadding="0" border="0" style="width: 100%; max-width: 600px; padding: 0; margin: 20px auto 0; background: #ffffff;" align="center">
                <tbody>
                    <tr>
                        <td align="center" style="background: #242424;">
                            <img src="https://arquivos.essentialnutrition.com.br/images/hoVetor.png"  alt="Símbolo Ho" title="Símbolo Ho" width="40" height="40" style="display: block!important; border-width: 0; margin: 15px 0 15px 0;" />
                        </td>
                    </tr>
                    <!--Start Section-->
                    <tr>
                        <td align="center" style="padding: 0 20px;">
                            <p id="email-subject" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; line-height: 26px; color: #242424; font-weight: bold; margin: 40px 0px 30px;">
                                Ol&aacute;, tudo bem?</p>
                            <p id="email-message" style="font-family: Arial, Helvetica, sans-serif; font-size: 17px; line-height: 22px; color: #242424; margin: 0 0 20px; max-width: 320px;">
                                {{-- Mensagem --}}
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #000; background-image: linear-gradient(180deg, #000, #000);">
                            <img src="https://arquivos.essentialnutrition.com.br/images/digital/marca_essentiagroup_rgb_horizontal.png" alt="Logo Essentia Group" title="Logo Essentia Group" style="display: block; width: 100%; height: 58px; max-width: 170px; margin: 40px 0px;" />
                            <hr style="color: #3d3935; max-width: 480px; margin: 20px 20px; border: 1px solid;" />
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 0 0px 40px; background-color: #000; background-image: linear-gradient(180deg, #000, #000);">
                            <div style="display: inline-block; width: 150px; vertical-align: top;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="width: 150px; padding: 0 0 0 5px; margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                <img src="https://arquivos.essentialnutrition.com.br/images/eventos/logo-pharmafooter-email-Essentia_group.png"  alt="Logo Essentia Pharma" title="Logo Essentia Pharma" style="display: block!important; border-width: 0; margin: 40px 0 0px 0; width: 100px;" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="display: inline-block; width: 180px; vertical-align: top;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="width: 150px; padding: 0 10px 0 20px; margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                <img src="https://arquivos.essentialnutrition.com.br/images/eventos/logo-essential-footer-email-Essentia_group1.png"  alt="Essentia Nutrition" title="Essentia Nutrition" style="display: block!important; border-width: 0; margin: 40px 0 0px 0; width: 100px;" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="display: inline-block; width: 150px; vertical-align: top;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0"  align="center"  style="width: 150px; padding: 0 0 0 10px; margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                    <img src="https://arquivos.essentialnutrition.com.br/images/eventos/logo-noorskin-footer-email-Essentia_group.png" alt="Logo noorskin" title="Logo noorskin" style="display: block!important; border-width: 0; margin: 47% 0 0 0; max-width: 100px; width: 100%;" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="display: inline-block; width: 180px; vertical-align: top;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0"  align="center" style="width: 150px; padding: 0; margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                <img src="https://arquivos.essentialnutrition.com.br/images/eventos/easy_health_logo_branco_horizontalfooter-email-Essentia_group.png" alt="Logo Easy Health" title="Logo Easy Health" style="display: block!important; border-width: 0; margin: 42% 0 0 10px; max-width: 110px; width: 100%;" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="display: inline-block; width: 150px; vertical-align: top;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                    align="center" style="width: 150px; padding: 0; margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                    <img  src="https://arquivos.essentialnutrition.com.br/images/eventos/logo-be-generous-footer-email-Essentia_group.png" alt="Logo Be Generous" title="Logo Be Generous" style="display: block!important; border-width: 0; margin: 41% 0 0 0; max-width: 100px; width: 100%;" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!-- End Footer -->
                </tbody>
            </table>
        </div>
    </div>
</x-app>

<script>
    const bodyInput = document.getElementById('body');
    const mensagemSpan = document.getElementById('email-message');

    bodyInput.addEventListener('input', (event) => {
        const mensagem = event.target.value;
        mensagemSpan.textContent = mensagem;
    });
</script>

