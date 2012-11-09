<?php
    /**
     * @file   jp.lang.php
     * @brief  掲示板 EX (bodex) 管理者モジュールの日本語パック
     **/
    $lang->cmd_view_filelist = '添付されたファイルリスト表示';
    $lang->use_doc_state_default_value = '待機,検討,完了,保留';


    $lang->best = 'ベスト';
    $lang->recent = '最近';
    $lang->download = 'ダウンロード';
    $lang->blind = 'ブラインド';

    $lang->declared_count = '申告された回数';
    $lang->about_new_download = '(ポイント使用方式がダウンロードなら記録されます)';

    $lang->search_display_item = '検索項目';
    $lang->list_target_item = '対象項目';
    $lang->list_display_item = '表示項目';
    $lang->list_sort_item = '整列使用';
    $lang->date_range = '日付範囲';
    $lang->except_notice = '公知除外';
    $lang->consultation = '相談機能';
    $lang->admin_mail = '管理者メール';
    $lang->auto_reply = '自動コメント';
    $lang->anonymous_phase = '匿名段階';
    $lang->notify_message_type = 'お知らせ方法';
    $lang->use_load_extra_vars = '多国語支援';

    $lang->cmd_bodex_content = '初期ページ';
    $lang->cmd_bodex_list = '掲示板リスト';
    $lang->cmd_Insert_bodex = '掲示板生成';
    $lang->cmd_view_info = '掲示板情報';
    $lang->cmd_list_setting = 'リスト設定';
    $lang->cmd_search_setting = '検索設定';
    $lang->cmd_recount_voted = '推薦数新たに更新';

    $lang->send_notify = 'メッセージ送り';
    $lang->send_mail = 'メール送り';

    $lang->use_none = '使用しない';
    $lang->use_yes = '選択使用';
    $lang->use_require = '必須使用';

    $lang->use_cat_comb = 'コンボボックス';
    $lang->use_cat_tab = 'タぶページ';
    $lang->use_cat_left = '左側メニュー';
    $lang->use_cat_right = '右側メニュー';

    $lang->use_vote = '推薦使用';
    $lang->use_vote_bonus = '推薦/非推薦受ければ上の点数位ポイントボーナスをもらう (星点の時, 推薦点数 * 星点数)';
    $lang->use_vote_empty = '推薦/非推薦点数を削除(初期化) 可能になるように許容';
    $lang->use_vote_not_checkip = '推薦/非推薦時 IP チェックをしない (私設ネットワークのように同じ IPを使わなければならない環境で使用)';

    $lang->use_doc_state ='状態機能';
    $lang->use_reward = 'ポイント使用';
    $lang->use_secret = '秘密文書機能';
    $lang->use_anonymous = '匿名使用';

    $lang->use_down_point_images = 'イメージファイルにもポイント適用';
    $lang->use_down_point_medias = 'メディアファイルにもポイント適用';
    $lang->use_down_point_always = 'ファイル別で毎度適用';

    $lang->use_allow = '許容';
    $lang->use_allow_none = '許容しない';
    $lang->use_allow_require = '常時許容';
    $lang->use_allow_yes = '選択許容';

    $lang->use_ex_search = '詳細検索使用';

    $lang->display_extra_images = 'アイコン表示';

    // 메세지에 사용되는 언어

    $lang->confirm_recount_voted = "データ量によって多少時間がかかることがあります.\n推薦数更新を続きますか?";
    $lang->msg_not_skin_info = "スキン情報を読み込むことができません.\n掲示板情報のスキン選択を確認してください.";

    // 주절 주절..
    $lang->about_bodex = '掲示板を生成管理することができるモジュールです. 詳細オプション修正は掲示板リストで該当の掲示板の設定ボタンを押してください.';
    $lang->about_except_notice = 'リスト上端に常に現われる告知事項を下端の一般リストでは出力しないように除外させます.';
    $lang->about_use_anonymous = '著者の情報を無くして匿名で掲示板使用ができるようにします.';
    $lang->about_consultation = '相談機能は管理権限のない会員は自分が書いた文書のみ見ることができる機能です.<br />会員だけ書き込みが許容され匿名機能使用の時保安段階は 1段階に調整されます.';
    $lang->about_secret = '掲示板及びコメントに秘密文を使うようにします. 必須の場合該当文は自動で秘密文になります.';
    $lang->about_admin_mail = '文書やコメントが登録される時メールアドレスでメールが発送されます.<br />,(コンマ)で連結の時多数のメールアドレスで発送することができます. (送信者と受信者が同じな場合には除かれます.)';
    $lang->about_search_setting = '掲示板の検索を項目で設定することができます. (拡張変数検索は拡張変数の検索項目を選択します)';
    $lang->about_list_config = '掲示板のリストを項目で配置することができます. (項目をダブルクリックすれば追加/除去になります)';
    $lang->about_use_category = '分類のスタイルをコンボボックス, タぶページ, 左側メニュー, 右側メニュー形態に指定することができます.';
    $lang->about_use_vote = '推薦する方法を指定することができます.  (ただし, 非会員は投票から除外)<br /><br /><span style="color:red">推薦数新たに更新</span>: 推薦形態が変わった時現状態に合うように数を更新します.<br />* 注意 * 推薦数更新はDBの値を直接修正することなので安全のためにバックアップの後行ってください.';
    $lang->about_use_doc_state_value = '使用することができる状態値のリストを指定することができます. (HTML タッグ使用可能)<br />多数登録は ,(コンマ) で区分します. (最大 10個使用可能 ex: 待機,検討,完了,保留)';
    $lang->about_use_doc_state = '文書の状態を設定して表示します. (リストで現在状態を確認するときはリスト設定で状態を使用ください.)';
    $lang->about_auto_reply = '新しい文書が登録されればその文書に自動で該当の内容のコメントを入力します. (HTML タッグ使用可能)';
    $lang->about_notify_message_type = '新しい文書やコメントが登録される時上位文書にお知らせ機能があればお知らせ方法を指定することができます.';
    $lang->about_module_text = '該当の掲示板モジュールの上, 下端に出力される内容を指定することができます.';
    $lang->about_constraint_document = '文書の一部のみ表示してコメントを入力するかポイントを支払うと全体を表示することができます.';
    $lang->about_constraint_download = '添付ファイルをダウンロードする時コメントを入力するかポイントを支払うことでダウンロードできるようにすることができます.';
    $lang->about_allow_comment = '掲示板にコメントまたは役人文を許容することができます.';
    $lang->about_use_anonymous_phase = '匿名使用の時保安のレベルを設定することができます.<br /><br />1. 最も低い段階で管理者には会員情報が表示されます. (相談掲示板同様)<br />2. 基本的な段階ですべての会員情報を表示しませんが最高管理者はdbを分析して分かる方法があります.<br />3. 最高段階で会員情報を誰もわからなくログアウト後には作成者も修正/削除が不可能です.';
    $lang->about_category_list = 'グループ制限の分類の文書は該当のグループのみ書き込みが可能です.';
    $lang->about_extra_vars = '検索をチェックすると検索設定を通じて検索が可能になります.';
    $lang->about_order_target = 'リストの基本整列項目と整列方式を指定します.<br />ランダムを選択するといつも無作為に表示します.';
    $lang->about_best_document = '選択したオプションにあたる文書を上端に配置して多くの人が読めるようにします. (コメントの整列対象は推薦数に固定)';
    $lang->about_load_extra_vars = '文書の多国語を支援します. (言語設定によって保存された内容を出力)<br />多国語支援が必要ない場合,使用しない設定のことでサイトの過負荷を少し減らすことができます.';
    $lang->about_display_extra_images = 'リストの題目横に出力されるアイコンを指定することができます.';
    $lang->about_declare_blind = '申告数が決まった数以上になると該当の文書がブラインド処理されます. (0 または空白は使用しない)';
    $lang->about_point_download = '添付ファイルをダウンするメンバーがバッティングされたポイントの 50%位をファイル持ち主に支払うようにします.<br />オプション "<B>ポイント使用</B>" 項目の設定値を調整してください.';
    $lang->about_point_view = '文書を閲覧するメンバーがバッティングされたポイントの 50%位を文書持ち主に支払うようにします.<br />オプション "<B>ポイント使用</B>" 項目の設定値を調整してください.';
    $lang->about_use_reward_value = '使用することができるポイント値のリストを指定することができます. (ex: 20,40,60,80,100)';
    $lang->about_use_reward = '<B>文書制限オプション使用の時:</B> 文書を閲覧する時 50%位を文書持ち主に支払うようにします.<br /><B>ダウンロード制限オプション使用の時:</B> ダウンロードする時 50%位をファイル持ち主に支払うようにします.<br /><B>その他:</B> 著者が返事を採択すれば採択されたメンバーに 50%, 著者にまた 50%のポイントが戻ります.';
    $lang->about_use_ex_search = '多くの拡張変数を検索可能になります.<br />検索設定に拡張変数を検索項目に登録した後使用ください.';

    // 모바일
    $lang->use_mobile = 'モバイルビュー使用';
    $lang->use_mobile_express = 'モバイル表示';
    $lang->mobile_skin = 'モバイルスキン';
    $lang->about_use_mobile = 'スマトホンなどを利用して接続する時モバイル画面に最適化されたレイアウトを利用するようにします.<br />モバイル表示: モバイル画面で作成された文書はアイコンで表示します.';
    $lang->use_mobile_doc_navigation = '以前/次出力';
    $lang->about_use_mobile_doc_navigation = 'モバイルレイアウト使用の時本文下端に以前/次のページの出力を設定することができます.';

?>
