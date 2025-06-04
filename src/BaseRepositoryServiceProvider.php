<?php

namespace Laravel\BaseRepository;

use App\Repositories\HR\CompanyVersionData\CompanyVersionDataRepository;
use App\Repositories\HR\CompanyVersionData\CompanyVersionDataRepositoryInterface;
use App\Repositories\HR\FixedData\FixedDataRepository;
use App\Repositories\HR\FixedData\FixedDataRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\App; // 追加
use Illuminate\Support\Facades\URL; // 追加
use App\Services\Calculations\CommuteAllowanceCalculationInputValue;
use App\Services\Calculations\CalculationFormulaInputValue;
use App\Services\Calculations\Contracts\CommuteAllowanceCalculationServiceInterface;
use App\Services\Calculations\Implementations\CommuteAllowanceCalculationService;
use App\Repositories\PR\PrintAsyncFileDownload\PrintAsyncFileDownloadRepositoryInterface;
use App\Repositories\PR\PrintAsyncFileDownload\PrintAsyncFileDownloadRepository;
use App\Repositories\PR\MstSalarySetting\MstSalarySettingRepositoryInterface;
use App\Repositories\PR\MstSalarySetting\MstSalarySettingRepository;
use App\Repositories\HR\Company\CompanyRepositoryInterface;
use App\Repositories\HR\Company\CompanyRepository;
use App\Repositories\PR\MstCompanyInitSetting\MstCompanyInitSettingRepository;
use App\Repositories\PR\MstCompanyInitSetting\MstCompanyInitSettingRepositoryInterface;
use App\Repositories\PR\TranBonus\TranBonusRepository;
use App\Repositories\PR\TranBonus\TranBonusRepositoryInterface;
use App\Repositories\PR\TranSalary\TranSalaryRepository;
use App\Repositories\PR\TranSalary\TranSalaryRepositoryInterface;


use App\Repositories\HR\CvWorkersAccidentInsuranceRatePr\CvWorkersAccidentInsuranceRatePrRepositoryInterface;
use App\Repositories\HR\CvWorkersAccidentInsuranceRatePr\CvWorkersAccidentInsuranceRatePrRepository;

class BaseRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(
            BaseRepositoryInterface::class,
            BaseRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
