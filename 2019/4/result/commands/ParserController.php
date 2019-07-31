<?php

namespace app\commands;

use app\models\Data;
use app\models\Weather;
use DiDom\Document;
use DiDom\Element;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

/**
 * Class ParserController
 * @package app\commands
 */
class ParserController extends Controller
{
    const URL = 'https://yandex.ru/pogoda/moscow/details';

    public function actionIndex()
    {
        $document = new Document(self::URL, true);

        $titleSelector = 'dt.forecast-details__day';
        $bodySelector = 'dd.forecast-details__day-info:not([data-bem])';

        $titleList = $document->find($titleSelector);
        $bodyList = $document->find($bodySelector);

        if (count($titleList) != count($bodyList)) {
            throw new Exception('Что-то пошло не так, разное количестов заголовков и таблиц.');
        }

        $titleData = [];
        foreach ($titleList as $item) {
            $titleData[] = $this->parseTitle($item);
        }
        $titleData = $this->addYearToTitles($titleData);

        $bodyData = [];
        foreach ($bodyList as $item) {
            $bodyData[] = $this->parseBody($item);
        }

        $this->saveData($titleData, $bodyData);
    }

    /**
     * @param Element $element
     * @return array
     * @throws Exception
     */
    private function parseTitle(Element $element): array
    {
        return [
            'date' => $element->first('.forecast-details__day-number')->text(),
            'mount' => $this->getMountNumber($element->first('.forecast-details__day-month')->text()),
        ];
    }

    /**
     * Возвращает номер месяца
     *
     * @param string $mount
     * @return string
     * @throws Exception
     */
    private function getMountNumber(string $mount): string
    {
        switch (mb_strtolower($mount)) {
            case 'января':
                return '01';
            case 'февраля':
                return '02';
            case 'марта':
                return '03';
            case 'апреля':
                return '04';
            case 'мая':
                return '05';
            case 'июня':
                return '06';
            case 'июля':
                return '07';
            case 'августа':
                return '08';
            case 'сентября':
                return '09';
            case 'октября':
                return '10';
            case 'ноября':
                return '11';
            case 'декабря':
                return '12';
        }

        throw new Exception("Не известный месяц $mount");
    }

    /**
     * @param Element $element
     * @return array
     */
    private function parseBody(Element $element): array
    {
        $days = [];

        foreach ($element->find('tbody tr') as $item) {
            $temperature = $this->getTemperatures($item->first('td'));

            $wind = '';
            $windDescription = '';

            $windElement = $item->first('.weather-table__body-cell_wrapper .wind-speed');

            if ($windElement) {
                $wind = $windElement->text();
                $windDescription = $item->first('.weather-table__body-cell_wrapper abbr')->attr('title');
            }

            $days[] = [
                'min_temperature' => $temperature['min'],
                'max_temperature' => $temperature['max'],
                'precipitation' => $item->first('.weather-table__body-cell_type_condition')->text(),
                'pressure' => $item->first('.weather-table__body-cell_type_air-pressure')->text(),
                'humidity' => (int)$item->first('.weather-table__body-cell_type_humidity')->text(),
                'wind' => str_replace(',', '.', $wind),
                'wind_direction' => $windDescription,
                'feels_like' => $item->first('.weather-table__body-cell_type_feels-like .temp__value')->text(),
            ];
        }

        $forecasts = $element->find('.forecast-fields__value');

        return [
            'days' => $days,
            'uv_index' => empty($forecasts[0]) ? null : $forecasts[0]->text(),
            'magnetic_field' => empty($forecasts[1]) ? null : $forecasts[1]->text(),
        ];
    }

    /**
     * @param Element $item
     * @return array
     */
    private function getTemperatures(Element $item): array
    {
        $temps = $item->find('.weather-table__temp .temp .temp__value');

        if (count($temps) == 0) {
            $temp = $item->first('.weather-table__temp .temp__value');

            return [
                'min' => $temp->text(),
                'max' => $temp->text(),
            ];
        }

        return [
            'min' => $temps[0]->text(),
            'max' => $temps[1]->text(),
        ];
    }

    /**
     * @param array $titleData
     * @return array
     */
    private function addYearToTitles(array $titleData): array
    {
        $prevMount = null;
        $year = (int)date('Y');

        foreach ($titleData as &$item) {
            if (!empty($prevMount)) {
                if ($prevMount < $item['mount'] && $prevMount == 12) {
                    $year++;
                }
            }

            $item['year'] = $year;
            $prevMount = $item['mount'];
        }

        return $titleData;
    }

    private function saveData(array $titleData, array $bodyData)
    {
        foreach ($bodyData as $key => $body) {
            $title = $titleData[$key];
            $date = sprintf('%s-%s-%s', $title['year'], $title['mount'], $title['date']);

            $model = Weather::findOneOrCreate(['date' => $date]);

            $model->uv_index = $body['uv_index'];
            $model->magnetic_field = $body['magnetic_field'];

            $model->save();

            /** @var Data[] $weatherData */
            $weatherData = ArrayHelper::index($model->data, 'times_of_day');

            foreach ($body['days'] as $dayKey => $day) {
                $dayIndex = $dayKey + 1;

                if (empty($weatherData[$dayIndex])) {
                    $data = new Data([
                        'weather_id' => $model->primaryKey,
                        'times_of_day' => $dayIndex,
                    ]);
                } else {
                    $data = $weatherData[$dayIndex];
                }

                $data->load($day, '');

                if (!$data->save()) {
                    var_dump($data->errors);
                    var_dump($day);
                }
            }
        }
    }
}
