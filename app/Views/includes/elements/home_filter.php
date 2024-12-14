<!-- Start of top filter   - D -->
<div id="locationContainer" class="locSearchContainer">
<span class="hiddenfilter-lg hiddenfilter-md hiddenfilter-sm">Filters</span><span class="CloseFilter">
<img src="<?= $images_static_path ?>icon-check.png">
<span class="sprite-icon mobilefilters-check-icon"></span>
</span>
<a class="btn collapsed city collapse_bt hiddenfilter-lg hiddenfilter-md hiddenfilter-sm"
 href="#headerDD" aria-expanded="false" aria-controls="collapseOne"  ng-click="getEventCount('','city')" ng-init="defaultFilter()"> 
 <span class="sprite-icon mobilefilters-city-icon hiddenfilter-lg hiddenfilter-md"></span>
 <span id="selectedCity" class="cityClass"><?= $defaultCityName ?></span>
 <span class="icon-downArrowH"></span>
</a>
<div class="SearchFilter_Holder hiddenfilter-xs hiddenfilter-md">
You are in <a class="btn collapsed city collapse_bt" href="#headerDD" aria-expanded="false" aria-controls="collapseOne" ng-click="getEventCount('','city')" ng-init="defaultFilter()">
<span id="selectedCity" class="cityClass"><?= ($defaultCityName === "All Cities") ? $defaultCountryName : $defaultCityName ?></span>
<span class="icon-downArrowH"></span>
</a> looking for <a class="btn collapsed categories collapse_bt" href="#headerDD1" aria-expanded="false" aria-controls="collapseTwo" ng-click="getEventCount('','category')" ng-init="selectedCategoryId=<?= $defaultCategoryId ?>"  >
<span class="categoryClass"><?= ($defaultCategory === "All Categories") ? "All" : $defaultCategory ?></span>
<span class="icon-downArrowH"></span>
</a>
events happening <a class="btn time collapsed collapse_bt" href="#headerDD2" aria-expanded="false" aria-controls="collapseThree" ng-init="selectedCustomFilterId=<?= $defaultCustomFilterId ?> ; selectedCustomFilterName='<?= $defaultCustomFilterName ?>'" ng-click="getEventCount('','customFilter')">
<span class="CustomFilterClass"><?= $defaultCustomFilterName ?></span>
<span class="icon-downArrowH"></span>
</a>
<span id="resetInput" ng-click="reset()" class="icon-refresh"></span>
</div>

<!-- City Filter -->
<div class="filterdiv hiddenfilter-lg hiddenfilter-md city-search-list" id="headerDD" style="width: 100%;">  
<div class="accTextCont cityList">
<span class="floatR locSearchContainer btnClass">
<a href="javascript:void(0)" class="btn">
<div class="sprite-icon close-icon"></div>
</a>
</span>
<h6>Top Cities</h6>
<ul ng-init="init(<?= htmlspecialchars(json_encode($cityList)) ?>,'city')">
<li ng-repeat="city in cityList | orderBy:'name'" id="{{city.id}}_mobcity">
<a title="{{city.name}}" ng-click="setFilter('city',city.id,city.name, 0,city.splcitystateid)">
<label ng-cloak>{{city.name}} <span ng-cloak>{{city.eventCount}}</span></label>
</a>
</li>
<li id="allcities">
<a ng-click="setFilter('city',0,'All Cities', 0,0)">
<label>All Cities <span ng-cloak>{{allCityCount}}</span></label>
</a>
</li>
</ul>
</div>
</div>

<!-- Category Filter -->
<div class="filterdiv hiddenfilter-lg hiddenfilter-md category-search-list" id="headerDD1" style="width: 100%;">
<div class="accTextCont categoryList">
<span class="floatR locSearchContainer btnClass">
<a href="javascript:void(0)" class="btn">
<div class="sprite-icon close-icon"></div>
</a>
</span>
<h6>Top Categories</h6>
<ul ng-init="init(<?= htmlspecialchars(json_encode($categoryList)) ?>,'category')">
<li ng-repeat="category in categoryList | orderBy:'name'" id="{{category.id}}_category">
<a title="{{category.name}}" ng-click="setFilter('category',category.id,category.name, 0,0)">
<i class="mecat-{{category.name | replaceSpaceFilter | lowercase}} col{{category.name | replaceSpaceFilter | lowercase}}"></i>
<label ng-cloak>{{category.name}} <span ng-cloak>{{category.eventCount}}</span></label>
</a>
</li>
<li id="allcategories">
<a ng-click="setFilter('category',0,'All Categories', 0,0)">
<label>All Categories <span ng-cloak>{{allCategoryCount}}</span></label>
</a>
</li>
<li id="subcat2" style="position: relative; display:<?= ($defaultCategoryId > 0) ? "inline-block" : "none" ?>">
<a id="showSubCateg" ng-click="getSubCategoryCount()" class="btn collapsed showSubCategories showMore"
data-parent="#headerDD1" href="#showMOre" aria-expanded="false"
aria-controls="showMore">Show Sub Categories</a>
</li>
</ul>
</div>
</div>

<!-- Date Filter -->
<div class="filterdiv hiddenfilter-lg hiddenfilter-md date-search-list" id="headerDD2" style="width: 100%;">
<div class="accTextCont dateList">
<span class="floatR locSearchContainer btnClass">
<a href="javascript:void(0)" class="btn">
<div class="sprite-icon close-icon"></div>
</a>
</span>
<h6>Dates</h6>
<ul ng-init="init(<?= htmlspecialchars(json_encode($customFilterList)) ?>,'customFilter')">
<li ng-repeat="customFilter in customFilterList" id="{{customFilter.id}}_dates">
<a ng-if="customFilter.id<7" title="{{customFilter.name}}" ng-click="setFilter('CustomFilter',customFilter.id,customFilter.name, 0,0)">
<label ng-cloak>{{customFilter.name}} <span ng-cloak>{{customFilter.eventCount}}</span></label>
</a>
</li>
</ul>
</div>
</div>
</div>