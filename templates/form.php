<?php
?>
<div id="form_container">
    <div id="error-message" class="alert alert-danger" role="alert" style="display: none"></div>
    <form action="" method="post" id="cvForm" data-toggle="validator" role="form"
          enctype='multipart/form-data'>
		<?php wp_nonce_field( 'wp_rest' ); ?>
        <div class="mb-3">
            <label for="firstname" class="form-label"> First Name:
                <input name="firstname"
                       value=""
                       type="text"
                       class="form-control"
                       required
                >
            </label>
        </div>
        <div class="mb-3">
            <label for="secondname" class="form-label"> Second Name:
                <input name="secondname"
                       value=""
                       type="text"
                       class="form-control"
                       required
                >
            </label>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label"> Email:
                <input name="email"
                       value=""
                       type="email"
                       class="form-control"
                       required
                >
            </label>
        </div>
        <div class="mb-3">
            <label for="cv-file" class="form-label"> First Name:
                <input name="cv-file"
                       value=""
                       type="file" accept="application/msword, application/pdf"
                       class="form-control"
                       required
                >
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
