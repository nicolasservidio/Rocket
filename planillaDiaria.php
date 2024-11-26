<?php include('head.php')?>

<body>

    <div class="wrapper">

        <?php 
    include('sidebarVentas.php');
    include('topNavBar.php');    
    ?>

        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <h3 class="fw-bold mb-3">Planilla Diaria</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <form class="row d-flex">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <label for="Oficina" class="form-label me-3 mt-2">Oficina</label>
                                            <input type="text" class="form-control form-control-sm" id="oficina">
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <label for="fecha" class="form-label me-3 mt-2">Fecha</label>
                                            <input type="date" class="form-control form-control-sm" id="fecha">
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <label for="vehiculo" class="form-label me-3 mt-2">Vehiculo</label>
                                            <input type="text" class="form-control form-control-sm mr-3" id="vehiculo">
                                        </div>

                                        <button type="button" class="btn btn-danger"><i class="fas fa-filter"></i>Filtrar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-auto">Oficina</th>
                                                <th class="col-auto">Matricula</th>
                                                <th class="col-auto">Modelo</th>
                                                <th class="col-auto">Estado</th>
                                                <th class="col-auto">Contrato</th>
                                                <th class="col-auto">Cliente</th>
                                                <th class="col-auto">F. Dev.</th>
                                                <th class="col-auto">HH Dev.</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                                $arrayPlanillaDiaria = ["OF", "AAA000", "Modelo ", "STA", "Contrato", "Cliente", "Fecha", "HHDev"];

                                                for ($i=0; $i < 8; $i++) { 
                                                    echo "<tr>";
                                                    for ($j=0; $j < 8; $j++) { 
                                                        echo "<td>$arrayPlanillaDiaria[$j].$i</td>";
                                                    }
                                                        "</tr>";
                                                }
                                            ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr class="mt-1 mb-1"/>
                            <div class="d-flex me-3 mt-3 mb-3 ml-5">
                            <button type="button" class="btn btn-danger m-3 ">Nuevo</button>
                            <button type="button" class="btn btn-danger m-3">Modificar</button>
                            <button type="button" class="btn btn-danger m-3">Imprimir</button>
                            <button type="button" class="btn btn-danger m-3">Borrar</button>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>
    
</body>

</html>