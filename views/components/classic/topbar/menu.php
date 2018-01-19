<?php

use yii\helpers\Url;
use app\models\Constantes;

?>
<div class="site-menubar site-menubar-light">
  <div class="site-menubar-body">
    <div>
      <div>
        <ul class="site-menu" data-plugin="menu">
          <li class="site-menu-category">General</li>
          <li class="dropdown site-menu-item">
            <a data-toggle="dropdown" href="/clientes/oscar/flow/web" data-dropdown-toggle="false">
              <i class="site-menu-icon pe-7s-edit" aria-hidden="true"></i>
              <span class="site-menu-title">Dashboard</span>
            </a>
          </li>
          <?php
          if(\Yii::$app->user->can(Constantes::USUARIO_CALL_CENTER)){?>
          
          <li class="dropdown site-menu-item has-sub">
            <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
              <i class="site-menu-icon pe-7s-headphones" aria-hidden="true"></i>
              <span class="site-menu-title">Citas</span>
              <span class="site-menu-arrow"></span>
            </a>
            <div class="dropdown-menu">
              <div class="site-menu-scroll-wrap is-list">
                <div>
                  <div>
                    <ul class="site-menu-sub site-menu-normal-list">
                      <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/citas">
                          <span class="site-menu-title">
                            <i class="site-menu-icon pe-7s-bookmarks" aria-hidden="true"></i>
                            Listado de citas</span>
                        </a>
                      </li>
                      <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/citas/create">
                          <span class="site-menu-title">
                            <i class="site-menu-icon pe-7s-plus" aria-hidden="true"></i>
                            Agregar cita
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <?php
          }
          ?>
          <?php
          if(\Yii::$app->user->can(Constantes::USURIO_ADMIN)){?>
          
          <li class="dropdown site-menu-item has-sub">
            <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
              <i class="site-menu-icon pe-users" aria-hidden="true"></i>
              <span class="site-menu-title">Usuarios</span>
              <span class="site-menu-arrow"></span>
            </a>
            <div class="dropdown-menu">
              <div class="site-menu-scroll-wrap is-list">
                <div>
                  <div>
                    <ul class="site-menu-sub site-menu-normal-list">
                      <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/usuarios">
                          <span class="site-menu-title">Listado de usuarios</span>
                        </a>
                      </li>
                      <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/admin/resultados-por-empleados">
                          <span class="site-menu-title">Agregar usuario</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <?php
          }
          ?>

          
        </ul>
      </div>
    </div>
  </div>
</div>