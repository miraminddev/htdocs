      <div class="container m-portlet">
        <div class="container wallet">
          <div class="my_wallet">
            <div class="col-md-3 wallet_img">
            My wallet
            <img src="assets/demo/demo2/media/img/logo/wallet.png" alt="">
          </div>
          <div class="col-md-9 wallet_eth">
            <div class="i-c-g" style="font-size: 1.3em">
              Your Ethereum address: <br>
              <span>
               <input id="val" type="text" name="" value="<?=$_SESSION['ulogin']['wallet']?>" placeholder="" style="width: 100%; padding: 0 20px">
               <span id="msgeth"></span>
                <br>
               <button onclick="post_wal()" type="button" class="btn btn-info" style="vertical-align: top; font-size: .8em; margin-top: 10px;">Save</button>
             </span>

            </div>
            <div class="i-c-g" style="font-size: 0.7em">
                         TOKEN ADDRESS (TO SHOW UP IN YOUR WALLET):    <br>
               <span class="wallet_info">0x8bcd8dafc917bfe3c82313e05fc9738aeb72d555</span>
            </div>
          </div>
        </div>
      </div>
<!--
        <div class="container">
          <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed" id="m_table_1" role="grid" aria-describedby="m_table_1_info">
              <thead>
                <tr role="row"><th class="sorting_desc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 54.5px;" aria-sort="descending" aria-label="
                    Registration Date
                  : activate to sort column ascending">
                    Date
                  </th><th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 70.5px;" aria-label="
                    Full name
                  : activate to sort column ascending">
                    Sum
                  </th><th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 87.5px;" aria-label="
                    E-mail
                  : activate to sort column ascending">
                    Rate
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 70.5px;" aria-label="
                    Full name
                  : activate to sort column ascending">
                    Tokens
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 70.5px;" aria-label="
                    Full name
                  : activate to sort column ascending">
                    Status
                  </th>
              </thead>
              <tbody>
              <tr role="row" class="odd">
                  <td class="sorting_1">
                    05.06.2018
                  </td>
                  <td class="black">
                    1.0000 ETH
                  </td>
                  <td class="black">
                    591.13 USD
                  </td>
                  <td class="black">
                    88669.35 MIRA
                  </td>
                  <td>
                    <div class="expect">
                      <i class="fas fa-clock"></i>
                      <span>Expectation</span>
                    </div>
                    <div class="successfull">
                      <i class="fas fa-check-circle"></i>
                      <span>Successfull</span>
                    </div>
                  </td>
                </tr>
                <tr role="row" class="even">
                  <td class="sorting_1">
                    05.06.2018
                  </td>
                  <td class="black">
                    1.0000 ETH
                  </td>
                  <td class="black">
                    591.13 USD
                  </td>
                  <td class="black">
                    88669.35 MIRA
                  </td>
                  <td>
                    <div class="expect">
                      <i class="fas fa-clock"></i>
                      <span>Expectation</span>
                    </div>
                    <div class="successfull">
                      <i class="fas fa-check-circle"></i>
                      <span>Successfull</span>
                    </div>
                  </td>
                </tr>
                <tr role="row" class="odd">
                  <td class="sorting_1">
                    05.06.2018
                  </td>
                  <td class="black">
                    1.0000 ETH
                  </td>
                  <td class="black">
                    591.13 USD
                  </td>
                  <td class="black">
                    88669.35 MIRA
                  </td>
                  <td>
                    <div class="expect">
                      <i class="fas fa-clock"></i>
                      <span>Expectation</span>
                    </div>
                    <div class="successfull">
                      <i class="fas fa-check-circle"></i>
                      <span>Successfull</span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
    </div>
-->

  </div>
